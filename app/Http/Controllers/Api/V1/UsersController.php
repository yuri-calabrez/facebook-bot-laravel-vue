<?php

namespace App\Http\Controllers\Api\V1;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    public function me()
    {
        $result = \Auth::user();
        $user = [];

        if($result) {
            $user = User::find($result->id);
        }

        return response()->json($user);
    }
}
