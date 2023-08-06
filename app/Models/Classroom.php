<?php

namespace App\Models;

use App\Models\Scopes\UserClassroomScope;
use App\Observers\ClassroomObserver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Classroom extends Model
{
    use HasFactory, SoftDeletes;


    protected $fillable = ['name', 'code', 'subject', 'section', 'room', 'cover_image_path', 'user_id'];




    // Global Scope



    // if i need to add boot  you must make this arent::boot();

    protected static function booted()
    {
        // static::addGlobalScope('users',function(Builder $query){

        //     $query->where('user_id','=',Auth::id());
        // });


        static::observe(ClassroomObserver::class);
        static::addGlobalScope(new UserClassroomScope);


        /*


        static::creating(function(Classroom $classroom){
            $classroom->code = Str::random(8);
            $classroom->user_id = Auth::id();

        });


       static::forceDeleted(function(Classroom $classroom){

        static::deleteCoverImage($classroom->cover_image_path);

       });

       static::deleted(function(Classroom $classroom){

         $classroom->status = 'deleted';


         $classroom->save();

       });


       static::restored(function(Classroom $classroom){

        $classroom->status = 'active';
          // to change the status
        $classroom->save();

      });
*/
    }

    // local scope
    public function scopeActive(Builder $query)
    {

        $query->where('status', '=', 'active');
    }


    //   public function scopeResent(Builder $query){

    //     $query->orderBy('updated_at','DESC');

    //   }



    // local scope with argement

    // public function scopeStatus(Builder $query , $status){

    //     $query->where('status','=',$status);

    //   }






    public function join($user_id, $role = 'student')
    {


        $this->usres()->attach($user_id,[
            'role' => $role,
            'created_at' => now()->format('Y-m-d H:i:s')
        ]);

        // DB::table('classroom_user')->insert([
        //     'classroom_id' => $this->id,
        //     'user_id' => $user_id,
        //     'role' => $role,
        //     'created_at' => now()->format('Y-m-d H:i:s')
        // ]);
    }



    // Accessor for found Attribute
    public function getNameAttribute($value)
    {

        return strtoupper($value);
    }


    public static function deleteCoverImage($path)
    {

        if ($path && Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->delete($path);
        }
    }


    // Accessor for found Attribute
    //   public function getCoverImagePathAttribute($value)
    //   {

    //     if($value){
    //         return Storage::disk("public")->url($value);
    //     }
    //     return 'https://placehold.co/800x300';

    //   }


    // Accessor for not found Attribute

    // public function getCoverImageURLAttribute()
    // {

    //   if($this->cover_image_path){
    //       return Storage::disk("public")->url($this->cover_image_path);
    //   }
    //   return 'https://placehold.co/800x300';

    // }




    public function getUrlAttribute()
    {
        return route('show.classroom', $this->id);
    }






    // relationships


    public function classworks(): HasMany
    {
        return $this->hasMany(ClassWork::class, 'classroom_id', 'id');
    }


    public function topics(): HasMany
    {
        return $this->hasMany(Topic::class, 'classroom_id', 'id');
    }




    public function usres()
    {
        return $this->belongsToMany(
            User::class, // Related Model
            'classroom_user', // Pivot Table
            'classroom_id',  // FK for current table in pivot model
            'user_id',      // FK for current table in pivot model
            'id',             // PK for current model
            'id'             // PK for related model

        )->withPivot(['role','created_at'])
        ->as('join')  // to replase pivot name to (join)
         ;
        //->wherePivot('role' ,'teacher')
    }



    public function teachers(){
        return $this->usres()->wherePivot('role','=','teacher');
    }

    public function students(){
        return $this->usres()->wherePivot('role','=','students');
    }
}
