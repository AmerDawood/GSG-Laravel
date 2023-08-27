<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Classroom;
use App\Models\ClassWork;
use App\Models\Scopes\UserClassroomScope;
use App\Models\User;
use App\Policies\ClassroomPolicy;
use App\Policies\ClassworkPolicy;
use Illuminate\Auth\Access\Response;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // ClassWork::class => ClassworkPolicy::class,
        // Classroom::class =>ClassroomPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {


         // befor , Gate , after


         Gate::before(function(User $user , $abillity){
            // return true;
            if($user->super_admin){
                return true;
            }
         });


        //  We replas all this using Policy

        Gate::define('classworks.view', function (User $user, ClassWork $classWork) {

          $teacher =  $user->classrooms()
                ->wherePivot('classroom_id', '=', $classWork->classroom_id)
                ->wherePivot('role', '=', 'teacher')->exists();


           $assigned  = $user->classworks()->withPivot('classwork_id','=',$classWork->id)->exists();



           return ($teacher || $assigned);
        });

        Gate::define('classworks.create', function (User $user, Classroom $classroom) {

        $result = $user->classrooms()
        ->withoutGlobalScope(UserClassroomScope::class)
                ->wherePivot('classroom_id', '=', $classroom->id)
                ->wherePivot('role', '=', 'teacher')->exists();


                return $result
                ? Response::allow()
                : Response::deny('You are not teacher in this classwork');
        });


        Gate::define('classworks.update', function (User $user, ClassWork $classWork) {

         return  $classWork->user_id == $user->id &&  $user->classrooms()
                ->wherePivot('classroom_id', '=', $classWork->classroom_id)
                ->wherePivot('role', '=', 'teacher')->exists();
        });


        Gate::define('classworks.delete', function (User $user, ClassWork $classWork) {

         return   $classWork->user_id == $user->id &&  $user->classrooms()
                ->wherePivot('classroom_id', '=', $classWork->classroom_id)
                ->wherePivot('role', '=', 'teacher')->exists();
        });



        Gate::define('submissions.create',function(User $user , ClassWork $classWork){
            $teacher =  $user->classrooms()
            ->wherePivot('classroom_id', '=', $classWork->classroom_id)
            ->wherePivot('role', '=', 'teacher')->exists();
            if($teacher){
                return false;
            }

            return $user->classworks()
            ->withPivot('classwork_id','=',$classWork->id)
            ->exists();

        });


    }
}
