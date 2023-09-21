<?php

namespace App\Http\Controllers;

use App\Events\ClassworkCreated;
use App\Models\Classroom;
use App\Models\ClassWork;
use App\Models\ClassworkUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

use function PHPSTORM_META\type;

class ClassWorkController extends Controller
{


    public function index(Classroom $classroom)
    {
        // lazy , get , pagination

        // viewAny
        // view-any
        $this->authorize('view-any',[ClassWork::class,$classroom]);


        $classworks =$classroom->classworks()
        ->with('topic') // Eager Load
        ->orderBy('published_at')
        ->where(function($query){
            $query->wherehas('users',function($query){
             $query->where('id','=',Auth::id());
         })

         ->orwherehas('classroom.teachers',function($query){
            $query->where('id','=',Auth::id());
         });

         })

         /*

         ->where(function($query){

         $query->whereRaw('EXISTS (SELECT 1 FROM classwork_user

         WHERE classwork_user.classwork_id =classworks.id

         AND classwork_user.user_id= ?)',[Auth::id()]);
         $query->orWhereRaw('EXISTS (SELECT 1 FROM classroom_user
         WHERE classroom_user.classroom_id =classworks.classroom_id
         AND classroom_user.user_id=?
         AND classroom_user.role=?

         )',[Auth::id(),'teacher']);

         })

         */


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

        // dd($request->all());

        // if(! Gate::allows('classworks.create',[$classroom])){
        //     abort(403);
        // }

        //  $this->authorize('create',[ClassWork::class,$classroom]);

        Gate::authorize('classworks.create',[$classroom]);


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
        if(Gate::denies('classworks.create',[$classroom])){
            abort(403);
        }

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
                'options' => [
                    'grade' => $request->input('options.grade'),
                    'due' => $request->input('options.due'),
                ],
                // 'options' => json_encode([
                //     'grade' =>$request->input('grade'),
                //     'due' =>$request->input('due'),
                // ])
                // 'options' => [
                //     'grade' =>$request->input('grade'),
                //     'due' =>$request->input('due'),
                // ]
            ];
            $classwork = $classroom->classworks()->create($data);

            $users = $request->post("student");

            // dd($classwork);
            foreach ($users as $userId) {
                $classwork_user = new ClassworkUser();
                $classwork_user->user_id = $userId;
                $classwork_user->class_work_id = $classwork->id;
                $classwork_user->save();
            }

           event(new ClassworkCreated($classwork));

        // ClassworkCreated::dispatch($classwork);

       // to add data to construct
        // ClassworkCreated::dispatch($classwork);




        //  $test =  $classwork->users()->attach($request->input('student'));
            // dd($test);

        });

        return redirect()->route('classrooms.classworks.index',$classroom->id)->with('success','Classwork Created Successfully');
        // return redirect()->route('classrooms.classworks.index')->with('success','Classwork Created Successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(Classroom $classroom, $classWorkId, ClassWork $classWork)
{

    $this->authorize('view',$classWork);
    // Gate::authorize('classworks.view',[$classWork]);

    $classWork = ClassWork::find($classWorkId);

    // dd($classWork);

    $submissions = Auth::user()->submissions()->where('classwork_id',$classWork->id)->get();


    if (!$classWork) {
        // Handle the case where the ClassWork is not found
        abort(404);
    }

    return view('classworks.show', compact('classroom', 'classWork','submissions'));
}



    public function edit(Request $request, Classroom $classroom, $classWorkId)
    {




        $classWork = ClassWork::findOrFail($classWorkId);

        $this->authorize('update',$classWork);

        // dd($classWork->type);


        $type = $classWork->type;


        // $type = $request->query('type');
        // $allowedTypes = [ClassWork::TYPE_ASSIGNMENT, ClassWork::TYPE_MATERIAL, ClassWork::TYPE_QUESTION];

        // if (!in_array($type, $allowedTypes)) {
        //     $type = ClassWork::TYPE_ASSIGNMENT;
        // }

        $assigned = $classWork->users()->pluck('id')->toArray();
        // dd($assigned);


        return view('classworks.edit', compact('classroom', 'classWork', 'type', 'assigned'));
    }



    public function update(Request $request, $classroom_id, $classwork_id)
    {
        $classWork = ClassWork::findOrFail($classwork_id);
        $classroom = Classroom::findOrFail($classroom_id);

        $this->authorize('update',$classWork);

        // return strip_tags($request->post('description',['p', 'h1' ,'li' ,'ol']));


        $type = $classWork->type;

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'topic_id' => ['nullable', 'int', 'exists:topics,id'],
            'published_at' => ['nullable'],
            'options.grade' => [Rule::requiredIf(fn() => $type == 'assignment'), 'numeric', 'min:0'],
            'options.due' => ['nullable', 'date', 'after:published_at'],
        ]);

        $classWork->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'topic_id' => $request->input('topic_id'),
            'published_at' => $request->input('published_at'),
            'options' => [
                'grade' => $request->input('options.grade'),
                'due' => $request->input('options.due'),
            ],
        ]);
        $users = $request->input('students', []); // Use an empty array if no students are selected

        foreach ($users as $userId) {
            $classWork->users()->syncWithoutDetaching([$userId]);
        }

        // $classroom->users()->sync($request->input('students'));
        // $assigned = $classWork->users()->pluck('id')->toArray();


        return back()->with('success', 'Classwork Updated');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClassWork $classWork)
    {
        $classwrok = ClassWork::findOrFail($classWork->id);

        $this->authorize('update',$classwrok);


        $classwrok->delete();

        return redirect()->route('classrooms.index')->with('success', 'Classwork Deleted Successfully');

    }
}
