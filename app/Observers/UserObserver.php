<?php
namespace BookStack\Observers;

use BookStack\Auth\User;
use Illuminate\Support\Str;

class UserObserver
{
    public function creating(User $user)
    {
        $user->fill([
            'authorization_token' => Str::random(32),
        ]);
    }
}