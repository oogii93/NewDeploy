<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\TimeOffRequestRecord;


class TimeOffRequestHumanResourcedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */

     public $timeOffRequest;
    public function __construct(TimeOffRequestRecord $timeOffRequest)
    {
        $this->timeOffRequest=$timeOffRequest;
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

        ->subject('休暇申請書届け')
        ->markdown('vendor.mail.html.time-off-request-HR',[
            'timeOffRequest'=>$this->timeOffRequest,
              'type' => $this->timeOffRequest->attendanceTypeRecord->name,

              'user_name'=>$this->timeOffRequest->user->name,


        ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray($notifiable): array
    {
        return [
            'message' => 'New time off request assigned to HR',
            'user_name' => $this->timeOffRequest->user->name,
            'date' => $this->timeOffRequest->date,
            // 'type' => $this->timeOffRequest->attendanceTypeRecord->name,
            'reason' => $this->timeOffRequest->reason,
        ];
    }
}
