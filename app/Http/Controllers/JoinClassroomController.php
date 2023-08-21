<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class JoinClassroomController extends Controller
{
    public function create($id)
    {

        $classroom = Classroom::active()->find($id);

        // $classroom = Classroom::all();

        // dd($classroom);


        try {

            $this->exists($id, Auth::id());
        } catch (Exception $e) {
            return redirect()->route('classrooms.show', $id);
        }


        return view('classrooms.join', compact('classroom'));
    }

    public function store(Request $request, $id)
    {


        $request->validate([
            'role' => 'in:student,teacher'
        ]);

        $classroom = Classroom::active()->findOrFail($id);


        try {
          $this->exists($id, Auth::id());
        } catch (Exception $e) {
            return redirect()->route('classrooms.show', $id);
        }

        $classroom->join(Auth::id(), $request->input('role','student'));

        // dd($request->all());

        return redirect()->route('classrooms.show',$id);
    }

    protected function exists($classroom_id, $user_id)
    {
        $exists = DB::table('classroom_user')
            ->where('classroom_id', $classroom_id)
            ->where('user_id', $user_id)
            ->exists();
        if ($exists) {
            throw new Exception('This User Is Joiend To This Classroom');
        }
    }
}
