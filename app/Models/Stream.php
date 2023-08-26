<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Stream extends Model
{
    use HasFactory , HasUuids;


    // protected $incrementing = false;
    // protected $keyType = 'string';


    protected $fillable = ['user_id','content','classroom_id','link'];


    // public static function booted()
    // {
    //     static::created(function(Stream $stream){
    //          $stream->id =  Str::uuid();
    //     });
    // }

    public function getUpdatedAtColumn()
    {

    }


    public function setUpdatedAt($value)
    {
         return $this;
    }

    public function classroom(){

        return $this->belongsTo(Classroom::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
