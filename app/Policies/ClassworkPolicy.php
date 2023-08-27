<?php

namespace App\Policies;

use App\Models\Classroom;
use App\Models\ClassWork;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ClassworkPolicy
{

    public function before(User $user , $abillity){
        if($user->super_admin){
            return true;
        }
    }

    public function after(User $user , $abillity){
        if($user->super_admin){
            return true;
        }
    }
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user , Classroom $classroom): bool
    {
        // dd($classroom);
        return $user->classrooms()->withPivot('classroom_id','=',$classroom->id)->exists();
    }

    /**
     * Determine whether the user can view the model.
     */
    // SHOW
    public function view(User $user, ClassWork $classWork): bool
    {

        $teacher =  $user->classrooms()
        ->wherePivot('classroom_id', '=', $classWork->classroom_id)
        ->wherePivot('role', '=', 'teacher')->exists();

        $assigned  = $user->classworks()->withPivot('classwork_id','=',$classWork->id)->exists();

        return ($teacher || $assigned);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user , Classroom $classroom): bool
    {

        $result = $user->classrooms()
        ->withoutGlobalScope(UserClassroomScope::class)
                ->wherePivot('classroom_id', '=', $classroom->id)
                ->wherePivot('role', '=', 'teacher')->exists();
                // dd($result);

                return $result;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ClassWork $classWork): bool
    {
        return  $classWork->user_id == $user->id &&  $user->classrooms()
                ->wherePivot('classroom_id', '=', $classWork->classroom_id)
                ->wherePivot('role', '=', 'teacher')->exists();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ClassWork $classWork): bool
    {
        return   $classWork->user_id == $user->id &&  $user->classrooms()
        ->wherePivot('classroom_id', '=', $classWork->classroom_id)
        ->wherePivot('role', '=', 'teacher')->exists();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ClassWork $classWork): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ClassWork $classWork): bool
    {
        //
    }
}
