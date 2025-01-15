<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\TimeOffRequestRecord;
use Illuminate\Notifications\Notification;

class TimeOffRequestCreatedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */

     public $timeOffRequest;
    public function __construct(TimeOffRequestRecord $timeOffRequest)
    {
        $this->timeOffRequest=$timeOffRequest->load('user');
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via( $notifiable)
    {
        return ['database','mail'];
    }

    /**
     * Get the mail representation of the notification.
     */

     public function toMail(object $notifiable): MailMessage
     {
        return (new MailMessage)
        ->subject('新しい休暇申請')
        ->markdown('vendor.mail.html.time-off-request', [
            'timeOffRequest' => $this->timeOffRequest,
            'actionText' => '申請を確認する',
            'actionUrl' => url('/time-off-requests/' . $this->timeOffRequest->id),
            'level' => 'primary'
        ]);
     }
    // public function toMail(object $notifiable): MailMessage
    // {
    //     return (new MailMessage)
    //     ->subject('新しい休暇申請') // Japanese subject
    //     ->greeting('こんにちは、' . $notifiable->name . 'さん')
    //     ->line($this->timeOffRequest->user->name . 'さんから休暇申請が提出されました。')
    //     ->line('申請内容:')
    //     ->line('日付: ' . $this->timeOffRequest->date)
    //     ->line('理由: ' . $this->timeOffRequest->reason)
    //     ->when($this->timeOffRequest->reason_select, function ($message) {
    //         return $message->line('種類: ' . $this->timeOffRequest->reason_select);
    //     })
    //     ->action('申請を確認する', url('/time-off-requests/' . $this->timeOffRequest->id))
    //     ->salutation('よろしくお願いいたします。');
    //                         }


    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray($notifiable)
    {
        return [
            'user_name'=>$this->timeOffRequest->user->name,

            'reason'=>$this->timeOffRequest->reason,


        ];
    }
}
