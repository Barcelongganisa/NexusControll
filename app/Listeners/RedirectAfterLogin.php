<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\Login;

class RedirectAfterLogin
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
     * @param  object  $event
     * @return void
     */
   public function handle(Login $event)
{
    $user = $event->user;
    
    if ($user->role === 'admin') {
        return redirect()->intended('/dashboard');
    }
    
    return redirect()->intended('/dashboard');
}
    
}
