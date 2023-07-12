<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Topic;
use Illuminate\Http\Request;

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
        return view('topics.create',compact('classroom'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $topic = new Topic();

        $topic->name = $request->post('name');
        $topic->classroom_id = $request->post('classroom_id');


        $topic->save(); // SAVE

        //PRG

        return redirect()->route('topics.index');
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

        return view('topics.edit',[
         'topic'=>$topic
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $topic = Topic::find($id);

        $topic->name = $request->post('name');
        $topic->classroom_id = $request->post('classroom_id');


        $topic->save(); // UPDATE

        return redirect()->route('topics.index');
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
       return redirect()->route('topics.index');
    }
}
