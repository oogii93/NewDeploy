<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Application2;

class NewApplication2Notification extends Notification
{
    use Queueable;

    public $application2;

    /**
     * Create a new notification instance.
     */
    public function __construct(Application2 $application2)
    {
        $this->application2=$application2;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database','mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)

                    ->subject('社内注文届')
                    ->markdown('vendor.mail.html.company-order',[

                     'application'=>$this->application2,
                     'user'=>$this->application2->user,
                     'created_at'=>$this->application2->created_at,





                    ]);

    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray( $notifiable): array
    {
        return [
            'type' => 'application2',

            'user_name' => $this->application2->user->name,
            'message' => 'New application request received',

            'application_id' => $this->application2->id,
            'created_at' => $this->application2->created_at,

        ];
    }
}
