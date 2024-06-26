<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Failed;
use App\Models\LoginRecord;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogFailedLogin
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Failed $event): void
    {
        if ($event->user) {
            LoginRecord::create([
                'user_id' => $event->user->id,
                'login_at' => now(),
                'ip_address' => request()->ip(),
                'client' => request()->header('User-Agent'),
                'successful' => false,
            ]);
        }
    }
}
