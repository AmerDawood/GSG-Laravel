<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\ClassWork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

use function PHPSTORM_META\type;

class ClassWorkController extends Controller
{


    public function index(Classroom $classroom)
    {
        // lazy , get , pagination


        $classworks =$classroom->classworks()
        ->with('topic') // Eager Load
        ->orderBy('published_at')
        ->get();

        // dd($classworks);

        // or
        // $classworks =$classroom->classworks;


        return view('classworks.index',[
            'classroom'=>$classroom,
            'classworks'=>$classworks->groupBy('topic_id'),
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create( Request $request ,Classroom $classroom)
    {

        // $type = request('type');

        //  $type = $this->getType($request);
        $type = $request->query('type');



        $allowd_types = [ClassWork::TYPE_ASSIGNMENT,ClassWork::TYPE_MATERIAL , ClassWork::TYPE_QUESTION];


        if(!in_array($type , $allowd_types)){
            // abort(404);

            $type = ClassWork::TYPE_ASSIGNMENT;
        }



        $classWork = new ClassWork();

        // dd($classwork);




        return view('classworks.create',[
            'classroom'=>$classroom,
            'type' => $type,
            'classWork' => $classWork,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Classroom $classroom)
    {

        // dd($request->all());
        $type = $request->query('type');


        $allowd_types = [ClassWork::TYPE_ASSIGNMENT,ClassWork::TYPE_MATERIAL , ClassWork::TYPE_QUESTION];


        if(!in_array($type , $allowd_types)){
            // abort(404);

            $type = ClassWork::TYPE_ASSIGNMENT;
        }

        $request->validate([
            'title'=>['required','string','max:255'],
            'description'=>['nullable','string'],
            'topic_id'=>['nullable','int','exists:topics,id'],
            'options.grade' => [Rule::requiredIf(fn() => $type == 'assignemt'),'numeric','min:0'],
            'options.due' => ['nullable','date','after:published_at'],
        ]);


        $request->merge([
            'user_id' => Auth::id(),
            'type' => $type,
        ]);



        // here we use relashinship to store the classwork




        DB::transaction(function() use ($classroom , $request,$type) {


            $data = [
                'user_id' =>auth()->user()->id,
                'type' =>$type,
                'title' =>$request->input('title'),
                'description' =>$request->input('description'),
                'topic_id' =>$request->input('topic_id'),
                'published_at' => $request->input('published_at', now()),
                // 'options' => json_encode([
                //     'grade' =>$request->input('grade'),
                //     'due' =>$request->input('due'),
                // ])
                'options' => [
                    'grade' =>$request->input('grade'),
                    'due' =>$request->input('due'),
                ]
            ];
            $classwork = $classroom->classworks()->create($data);


            $classroom->usres()->attach($request->input('student'));

        });



        return redirect()->route('classrooms.index')->with('success','Classwork Created Successfully');
        // return redirect()->route('classrooms.classworks.index')->with('success','Classwork Created Successfully');



    }

    /**
     * Display the specified resource.
     */
    public function show(Classroom $classroom, $classWorkId)
{
    $classWork = ClassWork::find($classWorkId);

    if (!$classWork) {
        // Handle the case where the ClassWork is not found
        abort(404);
    }

    return view('classworks.show', compact('classroom', 'classWork'));
}



    public function edit(Request $request, Classroom $classroom, $classWorkId)
    {


        $classWork = ClassWork::findOrFail($classWorkId);
        // dd($classWork->type);
     

        $type = $classWork->type;


        // $type = $request->query('type');
        // $allowedTypes = [ClassWork::TYPE_ASSIGNMENT, ClassWork::TYPE_MATERIAL, ClassWork::TYPE_QUESTION];

        // if (!in_array($type, $allowedTypes)) {
        //     $type = ClassWork::TYPE_ASSIGNMENT;
        // }

        $assigned = $classWork->users()->pluck('id')->toArray();


        return view('classworks.edit', compact('classroom', 'classWork', 'type', 'assigned'));
    }



    public function update(Request $request, $classroom_id, $classwork_id)
    {
        $classWork = ClassWork::findOrFail($classwork_id);
        $classroom = Classroom::findOrFail($classroom_id);

        $type = $classWork->type;

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'topic_id' => ['nullable', 'int', 'exists:topics,id'],
            'options.grade' => [Rule::requiredIf(fn() => $type == 'assignment'), 'numeric', 'min:0'],
            'options.due' => ['nullable', 'date', 'after:published_at'],
        ]);

        $classWork->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'topic_id' => $request->input('topic_id'),
            // ... other attributes
            'grade' => $request->input('options.grade'),
            'due' => $request->input('options.due'),
        ]);

        $classroom->usres()->sync($request->input('students'));

        return back()->with('success', 'Classwork Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClassWork $classWork)
    {
        $classwrok = ClassWork::findOrFail($classWork->id);

        $classwrok->delete();

        return redirect()->route('classrooms.index')->with('success', 'Classwork Deleted Successfully');

    }
}
