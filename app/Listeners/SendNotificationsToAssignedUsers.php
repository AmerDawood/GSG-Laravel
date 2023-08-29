<?php

namespace App\Listeners;

use App\Events\ClassworkCreated;
use App\Events\ClassworkUpdated;
use App\Notifications\NewClassworkNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendNotificationsToAssignedUsers
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
    public function handle(ClassworkCreated $event): void
    {

        // foreach($event->classWork->users as $user){
        //     $user->notify(new NewClassworkNotification($event->classWork));
        // }

        
        Notification::send($event->classWork->users,new NewClassworkNotification($event->classWork));
    }
}
