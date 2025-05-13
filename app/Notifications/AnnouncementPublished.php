<?php


namespace App\Notifications;

use App\Models\Announcement;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AnnouncementPublished extends Notification implements ShouldQueue
{
    use Queueable;

    public $announcement;

    public function __construct(Announcement $announcement)
    {
        $this->announcement = $announcement;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Announcement: ' . $this->announcement->title)
            ->greeting('Hello!')
            ->line('New announcement has been sent by your trainer, check it whenever you can ;)')
            ->action('View Announcement', url('http://localhost:8000/student-announcements'))
            ->line('Thanks for your time.')
            ->salutation('Regards, LMC');
    }
}
