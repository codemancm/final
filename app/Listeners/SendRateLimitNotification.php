<?php

namespace App\Listeners;

use App\Events\RateLimitExceeded;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendRateLimitNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\RateLimitExceeded  $event
     * @return void
     */
    public function handle(RateLimitExceeded $event)
    {
        $admins = User::whereHas('roles', function ($query) {
            $query->where('name', 'admin');
        })->get();

        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'title' => 'Rate Limit Exceeded',
                'message' => 'User ' . $event->user->username . ' has exceeded the rate limit.',
                'type' => 'alert',
            ]);
        }
    }
}
