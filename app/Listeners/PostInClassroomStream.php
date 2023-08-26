<?php

namespace App\Listeners;

use App\Events\ClassworkCreated;
use App\Models\Stream;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Str;

class PostInClassroomStream
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ClassworkCreated $event ): void
    {
        $classwork = $event->classWork;

        $content = __(':name Posted a new :type',[
            'name' => $classwork->users->name,
            'type' => $classwork->type,
        ]);

        Stream::create([
            
            'classroom' => $classwork->classroom_id,
            'user_id' => $classwork->user_id,
            'content' => $content,
            'link' => route('classrooms.classworks.show',$classwork->classroom_id , $classwork->id)
        ]);

    }
}
