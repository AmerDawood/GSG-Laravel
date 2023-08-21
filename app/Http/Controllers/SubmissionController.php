<?php

namespace App\Http\Controllers;

use App\Models\ClassWork;
use App\Models\ClassworkUser;
use App\Models\Submission;
use App\Rules\ForbiddenFile;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Throwable;

class SubmissionController extends Controller
{
    public function store(Request $request, ClassWork $classWork, $classWorkId)
    {
        Gate::authorize('submissions.create',[$classWork]);


        // Find the ClassWork instance using the provided $classWorkId
        $classWork = ClassWork::find($classWorkId);

        // Validate the incoming request data
        $request->validate([
            'files' => ['required', 'array'],
            'files.*' => ['file', new ForbiddenFile('text/x-php', 'application/x-httpd-php')],
        ]);

        // Check if the user is assigned to the classwork
        $assigned = $classWork->users()->where('id', auth()->user()->id)->exists();

        if (!$assigned) {
            abort(403); // Forbidden
        }

        DB::beginTransaction();

        try {
            $data = [];
            foreach ($request->file('files') as $file) {
                $data[] = [
                    'user_id' => auth()->user()->id,
                    'classwork_id' => $classWork->id,
                    'content' => $file->store("submissions/{$classWork->id}"),
                    'type' => 'file',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // Insert submissions into the database
            Submission::insert($data);

            // Update the status of the ClassworkUser
           ClassworkUser::where([
                'user_id' => auth()->user()->id,
                'class_work_id' => $classWork->id,
            ])->update([
                'status' => 'submitted',
                'submitted_at' => now(),
            ]);

            DB::commit(); // Commit the transaction

        } catch (Throwable $e) {
            DB::rollBack(); // Rollback the transaction in case of an exception
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'Work Submitted');
    }




      // File Proxy
    //    public function file(Submission $submission)
    //    {

    //     $url = $_SERVER['REQUEST_URI'];
    //     $parts = explode('/', $url); // Split the URL by slashes
    //     $submissionId = intval($parts[count($parts) - 2]);
    //     // dd($submissionId);

    //     $user = Auth::user();
    //     $submission = Submission::findOrFail($submissionId);

    //     // $submission = Submission::findOrFail($submission->id);
    //     // dd($submission);

    //     // $collection = DB::select('SELECT *
    //     // FROM clasroom_user
    //     // WHERE user_id = ? AND role = ? AND EXISTS (
    //     //     SELECT 1
    //     //     FROM class_works
    //     //     WHERE class_works.classroom_id = classroom_user.classroom_id AND EXISTS (
    //     //         SELECT 1
    //     //         FROM submissions
    //     //         WHERE submissions.class_work_id = class_works.id AND submissions.id = ?)
    //     // )', [$user->id, 'teacher', $submission->id]);


    //         //     $collection = DB::table('classroom_user')
    //         // ->where('user_id', $user->id)
    //         // ->where('role', 'teacher')
    //         // ->whereExists(function ($query) use ($submission) {
    //         //     $query->select(DB::raw(1))
    //         //         ->from('class_works')
    //         //         ->whereColumn('class_works.classroom_id', 'classroom_user.classroom_id')
    //         //         ->whereExists(function ($innerQuery) use ($submission) {
    //         //             $innerQuery->select(DB::raw(1))
    //         //                 ->from('submissions')
    //         //                 ->whereColumn('submissions.classwork_id', 'class_works.id')
    //         //                 ->where('submissions.id', $submission->id);
    //         //         });
    //         // })
    //         // ->get();



    //     //  dd($collection);


    //   // Check if the user is classroom teacher
    // //   $isTeacher = $submission->classwork->classroom->teachers()->where('id', $user->id)->exists();
    // $isTeacher = DB::table('class_works')
    // ->join('classrooms', 'class_works.classroom_id', '=', 'classrooms.id')
    // ->join('classroom_user', 'classrooms.id', '=', 'classroom_user.classroom_id')
    // ->where('classroom_user.user_id', $user->id)
    // ->where('classroom_user.role', 'teacher')
    // ->where('class_works.id', $submission->classwork_id)
    // ->exists();





    //    $isOwner= $submission->user_id == $user->id;


    // //    dd([
    // //     'User ID' => $user->id,
    // //     'Submission ID' => $submission->id,
    // //     'Submission User ID' => $submission->user_id,
    // //     'Submission Classwork ID' => $submission->classwork_id,
    // //     'Is Teacher' => $isTeacher,
    // //     'Is Owner' => $isOwner,
    // //      ]);


    //    if(!$isTeacher && !$isOwner){
    //      abort(403);
    //    }

    // //    dd($submission->content);

    // //    dd($submission->content);


    //     // return response()->download(storage_path('app/'.$submission->content));
    //     return response()->file(storage_path('app/'.$submission->content));

    //     // $fileFullPath = storage_path('app/' . $submission->content);

    //     // if (file_exists($fileFullPath)) {
    //     //     return response()->file($fileFullPath);
    //     // } else {
    //     //     return response()->json(['error' => 'File not found'], 404);
    //     // }

    //     // File => Show && save

    //     // dawonload => only save

    //    }



       public function file(Submission $submission)
       {

        $url = $_SERVER['REQUEST_URI'];
        $parts = explode('/', $url); // Split the URL by slashes
        $submissionId = intval($parts[count($parts) - 2]);

        $user = Auth::user();
        $submission = Submission::findOrFail($submissionId);


        $isTeacher = DB::table('class_works')
        ->join('classrooms', 'class_works.classroom_id', '=', 'classrooms.id')
        ->join('classroom_user', 'classrooms.id', '=', 'classroom_user.classroom_id')
        ->where('classroom_user.user_id', $user->id)
        ->where('classroom_user.role', 'teacher')
        ->where('class_works.id', $submission->classwork_id)
        ->exists();

           $isOwner= $submission->user_id == $user->id;

           if(!$isTeacher && !$isOwner){
             abort(403);
           }

           return response()->file(storage_path('app/'.$submission->content));


       }

    }

