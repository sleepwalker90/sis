<?php

namespace App\Listeners;



use App\Models\LoginRecord;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogSuccessfulLogin
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
    public function handle(Login $event): void
    {
        LoginRecord::create([
            'user_id' => $event->user->id,
            'login_at' => now(),
            'ip_address' => request()->ip(),
            'client' => request()->header('User-Agent'),
            'successful' => true,
        ]);
    }
}
