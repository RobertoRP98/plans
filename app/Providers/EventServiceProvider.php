<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;

class LoginRedirect
{
    public function handle(Login $event)
    {
        $user = $event->user;

        if ($user->hasRole('Developer')) {
            session(['url.intended' => route('anuncios.index')]);
        } else {
            session(['url.intended' => route('mis.anuncios')]);
        }
    }
}
