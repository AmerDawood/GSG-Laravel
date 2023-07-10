<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassroomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('classrooms')->insert(
            [

                'name'=>'Classroom1',
                'code'=>'101',
                'section'=>'22',
                'subject'=>'Sicence',
                'room'=>'Jerusalem',
                'theme'=>'light',
                'status'=>'active',

            ]
        );
    }
}
