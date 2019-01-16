<?php

namespace BookStack\Http\Controllers;

use BookStack\Auth\User;
use Illuminate\Http\Request;

class SearchUsersController extends Controller
{
    public function __invoke(Request $request)
    {
        $query = User::query();

        if($search = $request->get('query')) {
            $query->where('name', 'LIKE', "%$search%");
        }

        $users = $query->get();

        return response()->json($users);
    }
}
