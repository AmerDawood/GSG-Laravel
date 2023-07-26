<?php

namespace App\Http\Controllers;

use App\Http\Requests\TopicRequest;
use App\Models\Classroom;
use App\Models\Topic;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session as FacadesSession;

class TopicsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $topics = Topic::all();

        return view('topics.index',compact('topics'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $classroom = Classroom::all();
        return view('topics.create',compact('classroom'),[
            'topic'=>new Topic(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TopicRequest $request)
    {
         Topic::create($request->all());

        //PRG

        return redirect()->route('topics.index')->with('success','Topic Created Successfully');

    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $topic = Topic::find($id);

        return view('topics.show',[
            'topic'=>$topic,

        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $topic = Topic::find($id);

        $classroom = Classroom::all();

        return view('topics.edit',[
         'topic'=>$topic,
         'classroom'=>$classroom
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TopicRequest $request, string $id)
    {
        $topic = Topic::find($id);

        $topic->name = $request->post('name');
        $topic->classroom_id = $request->post('classroom_id');


        $topic->save(); // UPDATE


        return redirect()->route('topics.index')->with('error','Topic Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $topic = Topic::findOrFail($id);


        // if(!$classroom){
        //     abort(404);
        // }
        $topic->delete();
       return redirect()->route('topics.index')->with('msg','Topic Deleted Successfully');
    }




    public function trashed()
    {
        $topics = Topic::onlyTrashed()->latest()->get();


        return view('topics.trashed', compact('topics'));
    }

    public function restore($id)
    {

        $topic = Topic::onlyTrashed()->findOrFail($id);


        $topic->restore();

        return redirect()->route('topic.trashed')->with('success', 'Topic  Restored Successfully');
    }



    public function  forceDelete($id)
    {

        $topic = Topic::withTrashed()->findOrFail($id);

        $topic->forceDelete();


        return redirect()->route('topic.trashed')->with('success', 'Topic Force Delete Successfully');

    }



    public function classroomTopics($classroomId)
    {
        $topics = Topic::ClassroomId($classroomId)->get();

        return view('topics.classrooms', compact('topics'));

    }




}
