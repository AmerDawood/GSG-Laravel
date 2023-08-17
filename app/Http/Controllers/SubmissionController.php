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
use Throwable;

class SubmissionController extends Controller
{
    public function store(Request $request , ClassWork $classWork,$classWorkId)
    {


        $classWork = ClassWork::find($classWorkId);

        // dd($classWork);



        $request->validate([
            'files' =>['required','array'],
            'file.*' => ['file',new ForbiddenFile('text/x-php','application/x-httpd-php')]
        ]);
       $assigned =  $classWork->users()->where('id',auth()->user()->id)->exists();



    //    dd($assigned);

       if(!$assigned)
       {
        abort(403);
       }
        // $file->store;


        DB::beginTransaction();

        try{
            $data = [];
       foreach($request->file('files') as  $file){
         $data [] = [
            'user_id' => auth()->user()->id,
            'classwork_id' => $classWork->id,
            'content' => $file->store("submissions/{$classWork->id}"),
            'type' =>'file',
            'created_at' => now(),
            'updated_at' => now(),
          ];

             }
            Submission::insert([$data]);


            ClassworkUser::where([
                'user_id' => auth()->user()->id,
                'classwork_id' => $classWork->id,
            ])->update([
                'status' => 'submitted',
                'submitted_at' => now(),
            ]);


            DB::commit();

        }catch(Throwable $e){
            DB::rollBack();
        return back()->with('error',$e->getMessage());

        }




        return back()->with('success','Work Submitted');
       }




      // File Proxy
       public function file(Submission $submission)
       {


        $user = Auth::user();


          /*
           $collection = DB::select('SELECT * FROM clasroom_user
            WHERE user_id = ? AND
            role = ? AND EXIST (
                SELECT 1 FROM classworks WHERE classworks.classroom_id = classroom_user.classroom_id AND EXISTS(
                    SELECT 1 FROM submissions WHERE submissions.classwork_id = classworks.id AND
                     id = ?)
                     )',[$user->id , 'teacher',$submission->id]);

         dd($collection);
          */




      // Check if the user is classroom teacher
       $isTeacher =  $submission->classwork->classroom->teachers()->where('id',$user->id)->exists();

       $isOwner= $submission->user_id = $user->id;


       if(! $isTeacher && ! $isOwner){
         abort(403);
       }



        return response()->file(storage_path('app/'.$submission->content));

        // File => Show && save

        // dawonload => only save

       }

    }

