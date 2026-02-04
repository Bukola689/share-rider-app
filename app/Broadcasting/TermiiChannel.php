<?php

namespace App\Broadcasting;

use App\Models\User;
use App\Services\TermiiSmsService;
use Illuminate\Notifications\Notification;

class TermiiChannel
{

    /**
     * Create a new channel instance.
     */
    public function __construct(private TermiiSmsService $termii)
    {
        //
    }

     public function send($notifiable, Notification $notification): void
    {
        if (!method_exists($notification, 'toTermii')) {
            return;
        }

        $data = $notification->toTermii($notifiable);

        $this->termii->sendOtp($data['phone'], $data['message']);
    }

    /**
     * Authenticate the user's access to the channel.
     */
    public function join(User $user): array|bool
    {
        //
    }
}
