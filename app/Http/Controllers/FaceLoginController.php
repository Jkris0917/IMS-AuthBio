<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FaceLoginController extends Controller
{
    public function show()
    {
        return view('welcome');
    }

    public function authenticate(Request $request)
    {
        $input = collect($request->descriptor);
        $users = User::whereNotNull('face_descriptor')->get();

        foreach ($users as $user) {
            $stored = collect(json_decode($user->face_descriptor));
            if ($this->euclideanDistance($input, $stored) < 0.6) {
                Auth::login($user);
                return response()->json(['success' => true]);
            }
        }

        return response()->json(['success' => false]);
    }

    private function euclideanDistance($a, $b)
    {
        return sqrt($a->zip($b)->reduce(fn($sum, $pair) => $sum + pow($pair[0] - $pair[1], 2), 0));
    }
}
