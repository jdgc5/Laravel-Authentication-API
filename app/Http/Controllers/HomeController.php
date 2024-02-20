<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth')->except(['user','userName']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $user = $request->user();
        return view('home', ['user' => $user]);
    }

    
    public function user(Request $request) 
    {
    	if($request->user() != null) {
    		return response()->json(['user' => $request->user()]);
    	}
    	return response()->json(['user' => null]);
    }
        
}
