<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'content' =>'required|string|min:5',
            'id' => 'required',
            'type' =>'required'
        ]);

        Auth::user()->comments()->create([
            'commentable_id' => $request->input('id'), 
            'commentable_type' => 'App\Models\\'. ucfirst($request->input('type')),
            'content' => $request->content,
            'ip' => $request->ip(),
            'user_agent' => $request->header('user-agent'),
        ]);





        return redirect()->back()->with('success','Comment Created Successfully');

    }
}
