<?php

namespace BookStack\Http\Controllers;

use BookStack\Auth\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class SearchUsersController extends Controller
{
    public function __invoke(Request $request)
    {
        $query = User::query();

        if ($search = $request->get('query')) {
            $query->where('name', 'LIKE', "%$search%");
        }

        $query = $query->whereHas('roles', function (Builder $query) use ($request) {
            return $query->whereHas('permissions', function ($query) use ($request) {
                return $query->where('name', $request->get('permission_name'));
            });
        });
        $users = $query->get();

        return response()->json($users);
    }
}
