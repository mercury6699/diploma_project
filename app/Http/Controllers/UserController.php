<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Variable;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
//        $this->middleware('auth:api');
    }

    public function users_by_ids(Request $request): \Illuminate\Http\JsonResponse
    {
        $history_user_ids = $request->input('user_ids') ?? [];
        $users = User::whereIn('id', $history_user_ids)->get();

        if ($users->isEmpty()) {
            $users = [];
        }

        return response()->json([
            'status' => 'success',
            'users' => $users,
        ]);
    }
}
