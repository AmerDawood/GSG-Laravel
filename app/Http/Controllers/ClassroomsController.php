<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClassroomRequest;
use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ClassroomsController extends Controller
{
     public function index(){


        $classrooms =Classroom::orderBy('created_at','desc')->get();

        return view('classrooms.index',compact('classrooms'));
     }


     public function create(){

        return view('classrooms.create',[
            'classroom'=>new Classroom(),
        ]);

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

     public function update(ClassroomRequest $request, $id)
     {
         $classroom = Classroom::find($id);





        // $request->validate([
        //     'name' => 'required',
        //     'section' => 'required',
        //     'subject' => 'required',
        //     'room' => 'required',
        //     // 'cover_image' => 'required',
        // ]);

         if ($request->hasFile('cover_image')) {
             if ($classroom->cover_image_path) {
                 Storage::disk('public')->delete($classroom->cover_image_path);
             }

             $file = $request->file('cover_image');
             $path = $file->store('/covers', 'public');
             $request->merge([
                'cover_image_path'=>$path
             ]);
         } else {
             $path = $classroom->cover_image_path;
         }

         $classroom->update($request->all());

         return redirect()->route('classroom.index')->with('success','Classroom Updated Successfully');;
     }







     public function store(ClassroomRequest $request){


        // the data in ClassroomRequest validated
        // $validated = $request->validated();
        // $messages = [
        //     'name.required'=>'The name is requierd bro :)'
        // ];


        // $rules =[
        //     'name' => 'required|string|max:255',
        //     'section' => 'required|string|max:255',
        //     'subject' => 'required|string|max:255',
        //     'room' => 'required|string|max:255',
        //     // 'cover_image' => 'image|dimensions:width=200,height=100',
        //     'cover_image' => 'required|image',
        // ];



        // $request->validate($rules,$messages);





       if($request->hasFile('cover_image')){
        $file = $request->file('cover_image');
       $path = $file->store('/covers','public');
       $request->merge([
          'cover_image_path'=>$path
       ]);
       }

       $request->merge([
         'code'=>Str::random(10)
       ]);

       Classroom::create($request->all());

    //    $classroom->save(); // SAVE

       //PRG

       return redirect()->route('classroom.index')->with('success','Classroom Created Successfully');;

     }



     public function destroy($id)
     {
         $classroom = Classroom::findOrFail($id);

         if ($classroom->cover_image_path) {
             Storage::disk('public')->delete($classroom->cover_image_path);
         }

         $classroom->delete();

         return redirect()->route('classroom.index')->with('success','Classroom Deleted Successfully');;
     }

}
