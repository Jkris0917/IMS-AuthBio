<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();  // Logs the user out

        $request->session()->invalidate();  // Invalidates the session
        $request->session()->regenerateToken();  // Regenerates the CSRF token

        // Redirect with no-cache headers to prevent browser from storing the page
        return redirect()->route('home')
            ->with('success', 'Logout Successfully')
            ->withHeaders([
                'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
                'Pragma' => 'no-cache',
                'Expires' => 'Sat, 26 Jul 1997 05:00:00 GMT',
            ]);
    }
}
