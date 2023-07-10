<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClassroomsController extends Controller
{
     public function index(){

        return view('classrooms.index');
     }


     public function create(){
        return view('classrooms.create');

     }

     public function show(Request $request ,$name,$age){

        // $request->url();

        return view('classrooms.show',[
            'name'=>$name,
            'age'=>$age,
        ]);

     }


     public function edit($id){
       return view('classrooms.edit',[
        'id'=>$id
       ]);
     }
}
