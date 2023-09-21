<?php

namespace App\Notifications;

use App\Models\ClassWork;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewClassworkNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct (protected ClassWork $classWork)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {

        // $via = ['mail','database','broadcast'];
        $via = ['broadcast'];

        // if($notifiable->receive_mail_notifications){
        //     $via[] ='mail';
        // }
        // if($notifiable->receive_push_notifications){
        //     $via[] ='brodcast';
        // }

        return $via;

    }


    protected function createMessage(){

        $classwork = $this->classWork;
        $content = __(':name Posted a new :type :title',[
            'name' => $this->classWork->name,
            'type' => $this->classWork->type,
            'title' => $this->classWork->title,
        ]);

        return [
            'title' => __('New :type',[
                'type' => $classwork->type,
            ]),
            'body' =>$content,
            'image' => '',
            'link' => route('classrooms.classworks.show', ['classroom' => $classwork->classroom_id, 'classwork' => $classwork->id]),
            'classwork_id' => $classwork->id,
        ];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $classwork = $this->classWork;
        $content = __(':name Posted a new :type :title',[
            'name' => $this->classWork->name,
            'type' => $this->classWork->type,
            'title' => $this->classWork->title,
        ]);

        return (new MailMessage)
                    ->subject(__('New :type',['type' => $this->classWork->type]))
                    ->greeting(__('Hi :name',['name'=>$notifiable->name]))
                    ->line($content)
                    ->action('Go To Classwork',  route('classrooms.classworks.show', ['classroom' => $classwork->classroom_id, 'classwork' => $classwork->id]))
                    ->line('Thank you for using our application!');
    }




    public  function toDatabase(object $notifiable) : DatabaseMessage
    {

     return new DatabaseMessage($this->createMessage());
    }


    public  function toBrodcast(object $notifiable) : BroadcastMessage
    {

        return new BroadcastMessage($this->createMessage());

    }


    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
