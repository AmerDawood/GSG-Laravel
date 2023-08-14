<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\ClassWork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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



        $classwork = new ClassWork();

        // dd($classwork);




        return view('classworks.create',[
            'classroom'=>$classroom,
            'type' => $type,
            'classwork' => $classwork,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Classroom $classroom)
    {
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
        ]);


        $request->merge([
            'user_id' => Auth::id(),
            'type' => $type,
        ]);



        // here we use relashinship to store the classwork




        DB::transaction(function() use ($classroom , $request) {
            $classwork = $classroom->classworks()->create($request->all());


            $classroom->usres()->attach($request->input('student'));

        });



        return redirect()->route('classrooms.index')->with('success','Classwork Created Successfully');
        // return redirect()->route('classrooms.classworks.index')->with('success','Classwork Created Successfully');



    }

    /**
     * Display the specified resource.
     */
    public function show( Classroom $classroom,ClassWork $classWork)
    {

        $classWork = ClassWork::find($classWork->id);

        // dd($classroom);

        // if (!$classWork) {
        //     abort(404); // Display a "Not Found" page
        // }


        // $classWork->load('comments.user');

      return view('classworks.show',compact('classroom','classWork'));
    }

    /**
     * Show the form for editing the specified resource.
     */

    public function edit(Request $request , ClassWork $classWork ,Classroom $classroom)
    {

        $type = $request->query('type');


        $allowd_types = [ClassWork::TYPE_ASSIGNMENT,ClassWork::TYPE_MATERIAL , ClassWork::TYPE_QUESTION];


        if(!in_array($type , $allowd_types)) {
            // abort(404);

            $type = ClassWork::TYPE_ASSIGNMENT;
        }

        $assigned = $classWork->users()->pluck('id')->toArray();


        // dd($classWork);



        return view('classworks.edit',compact('classroom','classWork','type','assigned'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ClassWork $classWork , Classroom $classroom)
    {
        $classroom->update($request->all());

        $classroom->usres()->sync($request->input('students'));


        return back()->with('success','Classwork Updated');
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
