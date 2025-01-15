<?php

namespace App\Notifications;

use App\Models\TimeOffRequestRecord;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TimeOffRequestStatusChangedNotification extends Notification
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
                ->subject('休暇申請返事')
                                            ->markdown('vendor.mail.html.time-off-response',[
                                                'timeOffRequest'=>$this->timeOffRequest,
                                                  'type' => $this->timeOffRequest->attendanceTypeRecord->name,

                                            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray($notifiable)
    {
        return [
            'status'=>$this->timeOffRequest->status,
            'date'=>$this->timeOffRequest->date,
            'reason'=>$this->timeOffRequest->reason,

        ];
    }
}
