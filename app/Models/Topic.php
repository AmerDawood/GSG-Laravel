<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;


    protected $connection ='mysql';
    protected $table ='topics';


    protected $fillable =['name','classroom_id'];


    // protected $priimaryKey ='id';
    // protected $keyType ='int';

    // protected $incrementing = true;


    // protected $timestamps =false;


}
