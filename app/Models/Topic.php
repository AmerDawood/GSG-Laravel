<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Topic extends Model
{
    use HasFactory , SoftDeletes;


    protected $connection ='mysql';
    protected $table ='topics';


    protected $fillable =['name','classroom_id'];


    // protected $priimaryKey ='id';
    // protected $keyType ='int';

    // protected $incrementing = true;


    // protected $timestamps =false;


    // public static function booted(){

    //     static::addGlobalScope('topics',function( Builder $query){

    //         $query->where('classroom_id','=',45);

    //     });
    // }



    public function scopeClassroomId(Builder $query , $classroomId)
    {

        $query->where('classroom_id','=',$classroomId);

    }



}
