<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function loginForm()
    {
        return view('altLogin');
    }
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('username', 'password'))) {
            // Clear session cache if needed
            session()->forget('previous_url');

            // Redirect to the dashboard with no-cache headers
            return redirect()->route('admin.dashboard')->withHeaders([
                'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
                'Pragma' => 'no-cache',
                'Expires' => 'Sat, 26 Jul 1997 05:00:00 GMT',
            ])->with('success', 'Login successful!');
        }

        return back()->with('error', "Wrong Username or Password");
    }
}
