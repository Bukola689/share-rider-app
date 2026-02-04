<?php

namespace App\Notifications\Channels;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\TermiiSmsService;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TermiiChannel extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
   public function __construct(private TermiiSmsService $termii) {}

    public function send($notifiable, Notification $notification)
    {
         if (!method_exists($notification, 'toTermii')) {
            return;
        }

        $data = $notification->toTermii($notifiable);

        $this->termii->send($data['phone'], $data['message']);
    }
    
    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    // public function via(object $notifiable): array
    // {
    //     return ['mail'];
    // }

    /**
     * Get the mail representation of the notification.
     */
    // public function toMail(object $notifiable): MailMessage
    // {
    //     return (new MailMessage)
    //                 ->line('The introduction to the notification.')
    //                 ->action('Notification Action', url('/'))
    //                 ->line('Thank you for using our application!');
    // }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    // public function toArray(object $notifiable): array
    // {
    //     return [
    //         //
    //     ];
    // }
}
