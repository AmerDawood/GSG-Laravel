<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    // public function setEmailAttribute($value)
    // {
    //     $this->attributes['email'] = strtolower($value);
    // }


    // the new way

    protected function email() : Attribute
    {
        return Attribute::make(
            get: fn ($value) =>strtoupper($value),
            set: fn ($value) =>strtolower($value),

        );

    }



    // many to many

    public function classrooms()
    {
        return $this->belongsToMany(
            Classroom::class,    // Related Model
            'classroom_user',    // Pivot Table
            'user_id',           // FK for current table in pivot model
            'classroom_id',      // FK for current table in pivot model
            'id',                // PK for current model
            'id'                 // PK for related model

        )->withPivot(['role','created_at'])
        ->as('join'); // to replase pivot name to (join)

    }


    public function createdClassrooms()
    {
      return $this->hasMany(Classroom::class);
    }



    public function classworks()
    {
        return $this->belongsToMany(ClassWork::class)

         ->with(ClassworkUser::class)
         ->withPivot(['grade','status','submitted_at','created_at']);
    }




    public function comments()
    {
        return $this->hasMany(Comment::class);
    }




    public function submissions()
    {
      return  $this->hasMany((Submission::class));
    }



}
