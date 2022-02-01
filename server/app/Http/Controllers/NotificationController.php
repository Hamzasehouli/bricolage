<?php

namespace App\Http\Controllers;

use Illuminate\Notifications\Messages\NexmoMessage;

class NotificationController extends Controller
{
    /**
     * Get the Vonage / SMS representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return Illuminate\Notifications\Messages\NexmoMessage
     */
    public function toNexmo($notifiable)
    {
        return (new NexmoMessage)->content('Your unicode message')->unicode();
    }

    public function toShortcode($notifiable)
    {
        return [
            'type' => 'alert',
            'custom' => [
                'code' => 'ABC123',
            ],
        ];
    }
}