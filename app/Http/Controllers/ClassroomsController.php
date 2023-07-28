<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClassroomRequest;
use App\Models\Classroom;
use App\Models\Scopes\UserClassroomScope;
use App\Models\Topic;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class ClassroomsController extends Controller
{

    public function index()
    {


        // $classrooms = Classroom::orderBy('created_at', 'desc')->dd();


        // when you need to get local scope get only the name without scope in start
        $classrooms = Classroom::
        // active()
        // ->resent()
        // ->status('active')
        where('user_id',Auth::id())->
        orderBy('created_at', 'desc')
        // ->withoutGlobalScopes() // stop all global scopes  also soft delete
        ->withoutGlobalScope(UserClassroomScope::class)

        ->get();



        // The Query Builder not work automaticlly with soft delete  like this :
        // $classrooms = DB('classroom')->orderBy('created_at','desc')->dd();   this code doss not  work with query       builder with the soft delete , you must add the where deleted_at == null

        return view('classrooms.index', compact('classrooms'));
    }


    public function create()
    {

        return view('classrooms.create', [
            'classroom' => new Classroom(),
        ]);
    }

    public function show($id)
    {

        // $request->url();

        $classroom = Classroom::find($id);

        $invetation_link = URL::signedRoute('classroom.join',[
            'classroom'=>$classroom->id,
            'code' => $classroom->code,
        ]);

        return view('classrooms.show')->with([
            'classroom' => $classroom,
            'invetation_link'=> $invetation_link,

        ]);
    }









    public function edit($id)
    {
        $classroom = Classroom::find($id);

        return view('classrooms.edit', [
            'classroom' => $classroom
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
                'cover_image_path' => $path
            ]);
        } else {
            $path = $classroom->cover_image_path;
        }

        $classroom->update($request->all());

        return redirect()->route('classroom.index')->with('success', 'Classroom Updated Successfully');;
    }







    public function store(ClassroomRequest $request)
    {


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





        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');
            $path = $file->store('/covers', 'public');
            $request->merge([
                'cover_image_path' => $path
            ]);
        }

        $request->merge([
            'code' => Str::random(10)
        ]);
        $request->merge([
            'user_id' =>Auth::id(),
        ]);


        DB::beginTransaction();



        // DB::transaction(function(){});  another way to use the transaction


        try{
            $classroom=   Classroom::create($request->all());



        // DB::table('classroom_user')->insert([
        //     'classroom_id' => $classroom->id,
        //     'user_id' => Auth::id(),
        //     'role' => $request->input('role', 'student'),
        //     'created_at' => now()->format('Y-m-d H:i:s')
        // ]);


        $classroom->join(Auth::id(), 'teacher');

        DB::commit();

        }catch(Exception $e){

            DB::rollBack();


            return back()->with('error',$e->getMessage())->withInput();

        }



        //PRG

        return redirect()->route('classroom.index')->with('success', 'Classroom Created Successfully');;
    }



    public function destroy($id)
    {
        $classroom = Classroom::findOrFail($id);

        //  if ($classroom->path) {
        //      Storage::disk('public')->delete($classroom->cover_image_path);
        //  }

        $classroom->delete();

        return redirect()->route('classroom.index')->with('success', 'Classroom Deleted Successfully');
    }




    public function trashed()
    {
        $classrooms = Classroom::onlyTrashed()->latest()->get();


        return view('classrooms.trashed', compact('classrooms'));
    }

    public function restore($id)
    {

        $classroom = Classroom::onlyTrashed()->findOrFail($id);


        $classroom->restore();
        return redirect()->route('classroom.trashed')->with('success', 'Classroom # ({$classroom->name}) Restored Successfully');
    }



    public function  forceDelete($id)
    {

        $classroom = Classroom::withTrashed()->findOrFail($id);

        $classroom->forceDelete();
        if ($classroom->path) {
            Storage::disk('public')->delete($classroom->cover_image_path);
        }

        return redirect()->route('classroom.trashed')->with('success', 'Classroom # ({$classroom->name}) Force Delete Successfully');


    }
}
