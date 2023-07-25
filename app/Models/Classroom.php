<?php

namespace App\Models;

use App\Models\Scopes\UserClassroomScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Classroom extends Model
{
    use HasFactory , SoftDeletes;


    protected $fillable = ['name','code','subject','section','room','cover_image_path','user_id'];




     // Global Scope



      // if i need to add boot  you must make this arent::boot();

     protected static function booted()
     {
        // static::addGlobalScope('users',function(Builder $query){

        //     $query->where('user_id','=',Auth::id());
        // });


        static::addGlobalScope(new UserClassroomScope);
     }

    // local scope
    // public function scopeActive(Builder $query){

    //     $query->where('status','=','active');

    //   }


    //   public function scopeResent(Builder $query){

    //     $query->orderBy('updated_at','DESC');

    //   }



    // local scope with argement

    // public function scopeStatus(Builder $query , $status){

    //     $query->where('status','=',$status);

    //   }

}
