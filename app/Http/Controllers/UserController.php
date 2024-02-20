<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function user(Request $request)
    {
        return response()->json(['user' => $request->user()]);
    }
}
