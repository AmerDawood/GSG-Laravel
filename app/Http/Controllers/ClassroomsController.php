<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ClassroomsController extends Controller
{
     public function index(){


        $classrooms =Classroom::orderBy('created_at','desc')->get();

        return view('classrooms.index',compact('classrooms'));
     }


     public function create(){
        return view('classrooms.create');

     }

     public function show($id){

        // $request->url();

        $classroom = Classroom::find($id);

        return view('classrooms.show',[
            'classroom'=>$classroom,

        ]);

     }


     public function edit($id){
        $classroom = Classroom::find($id);

       return view('classrooms.edit',[
        'classroom'=>$classroom
       ]);
     }



     public function update(Request $request ,$id){
        $classroom = Classroom::find($id);

        $classroom->name = $request->post('name');
        $classroom->section = $request->post('section');
        $classroom->subject = $request->post('subject');
        $classroom->room = $request->post('room');
        // $classroom->code = Str::random(10);

        $classroom->save(); // UPDATE

        return redirect()->route('classroom.index');

     }


     public function store(Request $request){

       $classroom = new Classroom();

       $classroom->name = $request->post('name');
       $classroom->section = $request->post('section');
       $classroom->subject = $request->post('subject');
       $classroom->room = $request->post('room');
       $classroom->code = Str::random(10);

       $classroom->save(); // SAVE

       //PRG

       return redirect()->route('classroom.index');

     }



    public function destroy($id)
    {


        $classroom = Classroom::findOrFail($id);


        // if(!$classroom){
        //     abort(404);
        // }
        $classroom->delete();
       return redirect()->route('classroom.index');


    }
}
