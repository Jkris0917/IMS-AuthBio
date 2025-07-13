<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function show()
    {
        return view('register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'fname' => 'required|string|max:255',
            'mname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
            'face_descriptor' => 'required',
            'face_image' => 'required'
        ]);

        $base64Image = explode(';base64,', $request->face_image)[1];
        $filename = 'face_' . time() . '.png';
        $path = 'face_images/' . $filename;

        file_put_contents(public_path($path), base64_decode($base64Image));

        $user = User::create([
            'role' => 'admin',
            'fname' => $request->fname,
            'mname' => $request->mname,
            'lname' => $request->lname,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'face_descriptor' => $request->face_descriptor,
            'face_image_path' => $path
        ]);

        return redirect()->back()->with('success', "Registered Successfully");
    }
}
