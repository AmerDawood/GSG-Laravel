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


    public function __construct(){
        $this->middleware('auth');
        // $this->authorizeResource(Classroom::class);
    }

    public function index()
    {




        // when you need to get local scope get only the name without scope in start
        $classrooms = Classroom::
        // active()  // loacl scope
        // ->resent() // loacla scope
        // ->status('active') // local scope
        where('user_id',Auth::id())->
        orderBy('created_at', 'desc')
        // stop all global scopes  also soft delete
        // ->withoutGlobalScopes()
        ->withoutGlobalScope(UserClassroomScope::class)
        ->paginate(5);




        // The Query Builder not work automaticlly with soft delete  like this :
        // $classrooms = DB('classroom')->orderBy('created_at','desc')->dd();
        // this code doss not  work with query builder with the soft delete , you must add the where deleted_at == null

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

        // $request->url(); to get the URL

        $classroom = Classroom::findOrFail($id);

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

        return redirect()->route('classrooms.index')->with('success', 'Classroom Updated Successfully');;
    }







    public function store(ClassroomRequest $request)
    {

        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');
            $path = $file->store('/covers', 'public');
            $request->merge([
                'cover_image_path' => $path
            ]);
        }



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
        return redirect()->route('classrooms.index')->with('success', 'Classroom Created Successfully');;
    }



    public function destroy($id)
    {
        $classroom = Classroom::findOrFail($id);

        //  if ($classroom->path) {
        //      Storage::disk('public')->delete($classroom->cover_image_path);
        //  }

        $classroom->delete();

        return redirect()->route('classrooms.index')->with('success', 'Classroom Deleted Successfully');

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

        // if ($classroom->path) {
        //     Storage::disk('public')->delete($classroom->cover_image_path);
        // }

        //  Classroom::deleteCoverImage($classroom->cover_image_path);


        return redirect()->route('classroom.trashed')->with('success', 'Classroom # ({$classroom->name}) Force Delete Successfully');


    }
}
