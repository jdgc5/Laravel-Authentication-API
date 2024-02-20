<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use App\Models\User;
use Hash;
// use Illuminate\Support\Facades\Auth;

class AuthController extends Controller {
    
    
    function __construct(){
        $this->middleware('auth:api')->except(['login','register','isAuthenticated',]);
        //$this->middleware('auth:api')->only(['logout','user']);
    }

    function login(Request $request) {
         $request->validate([
             'email' => 'required|string|email',
             'password' => 'required|string',
             ]);
         $credentials = request(['email', 'password']);
         if (!Auth::attempt($credentials)) {
             return response()->json(['message' => 'Unauthorized'], 401);
         }
         $user = $request->user();
         $tokenResult = $user->createToken('accessToken');
         $token = $tokenResult->token;
         $token->save();
         return response()->json([
             'access_token' => $tokenResult->accessToken,
             'token_type' => 'Bearer',
             'expires_at' => Carbon::parse($token->expires_at)->toDateTimeString()
         ]);
    }
        
    //   function logout(Request $request) {
    //     if ($request->user()) {
    //         $request->user()->token()->revoke();
    //         return response()->json(['message' => 'User has logged out']);
    //     } else {
    //         return response()->json(['message' => 'No user authenticated'], 401);
    //     }
    // }
    function logout(Request $request) {
        $user = $request->user();
        
        if ($user) {
            $token = $user->token();
    
            if ($token) {
                $token->revoke();
                return response()->json(['message' => 'User has logged out']);
            } else {
                return response()->json(['message' => 'No token found for the user'], 401);
            }
        } else {
            return response()->json(['message' => 'No user authenticated'], 401);
        }
    }

        
    function register(Request $request) {
        
         $request->validate([
             'email' => 'required|string|email|unique:users',
             'name' => 'required|string',
             'password' => 'required|string',
         ]);
         
         User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        
        return response()->json(['message' => 'User has been created'],201);
            
    }
    
    public function user(Request $request) {
        $user = $request->user();
    
        if ($user) {
            return response()->json(['user' => $user]);
        } else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }

    
    public function isAuthenticated(Request $request)
    {
        $user = $request->user();
        
        if ($user) {
            return response()->json(['authenticated' => true, 'user' => $user]);
        } else {
            return response()->json(['authenticated' => false]);
        }
    }

    
}
