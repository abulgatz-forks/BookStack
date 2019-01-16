<?php

namespace BookStack\Http\Controllers\Auth;

use BookStack\Auth\User;
use Illuminate\Http\Request;
use BookStack\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TokenController extends Controller
{
    public function generate(User $user, Request $request)
    {
        $this->checkPermission('users-manage');

        $user->fill([
            'authorization_token' => $request->get('delete') ? null : Str::random(32),
        ])->save();

        return redirect()->back();
    }

    public function handle(Request $request)
    {
        $token = $request->get('token');

        $user = User::query()->where('authorization_token', $token)->first();

        Auth::login($user);

        $path = $request->get('redirect') ?: '';

        return redirect()->to($path);
    }

    public function retrieve(Request $request)
    {
        $user = User::findOrFail($request->get('user'));

        if (! $user->authorization_token) {
            $user->fill([
                'authorization_token' => Str::random(32),
            ])->save();
        }

        $link = $user->authorization_link . '&' . http_build_query(['redirect' => $request->get('link')]);

        return response()->json(compact('link'));
    }
}
