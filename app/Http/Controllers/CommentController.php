<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'comment' =>'required|string|min:5',
            'id' => 'required',
            'type' =>'required'
        ]);

        Auth::user()->comments()->create([
            'commetable_id' => $request->input('id'),
            'commetable_type' => 'App\Models\\'. ucfirst($request->input('type')),
            'content' => $request->content,
            'ip' => $request->ip(),
            'user_agent' => $request->header('user-agent'),
            // 'user_agent' => $request->userAgent(),
        ]);



        return redirect()->back()->with('success','Comment Created Successfully');

    }
}
