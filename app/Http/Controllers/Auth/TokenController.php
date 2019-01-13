<?php

namespace BookStack\Http\Controllers\Auth;

use BookStack\Auth\User;
use Illuminate\Http\Request;
use BookStack\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TokenController extends Controller
{
    public function generate(User $user)
    {
        $this->checkPermission('users-manage');

        $user->fill([
            'authorization_token'   =>  Str::random(32)
        ])->save();

        return redirect()->back();
    }

    public function handle(Request $request)
    {
        $token = $request->get('token');

        $user = User::query()->where('authorization_token', $token)->firstOrFail();

        Auth::login($user);

        return redirect()->to('/');
    }
}
