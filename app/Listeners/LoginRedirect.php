<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LoginRedirect
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
        $user = $event->user;

        // Guardamos redirección en sesión para Inertia
        if ($user->hasRole('Developer')) {
            session(['url.intended' => route('anuncios.index')]);
        } else {
            session(['url.intended' => route('mis.anuncios')]);
        }
    
    }
}
