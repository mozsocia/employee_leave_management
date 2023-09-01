<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LeaveCreated extends Notification
{
    use Queueable;
    protected $leave;

    /**
     * Create a new notification instance.
     *
     * @param Leave $leave
     */
    public function __construct($leave)
    {
        $this->leave = $leave;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('A leave has been created.')
            ->line('Created by: ' . $this->leave->user->email)
            ->action('View Leave', route('manager.leaves.edit', $this->leave->id))
            ->line('Thank you for using our application!');
    }

    public function toArray($notifiable)
    {
        return [
            // Additional data to send in the notification
        ];
    }
}
