<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id', 'desc')->get();

        return view('userList', compact('users'));
    }

    public function create()
    {
        return view('addUser');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Delete face image if exists
        if ($user->face_image_path && File::exists(public_path($user->face_image_path))) {
            File::delete(public_path($user->face_image_path));
        }

        // Delete user
        $user->delete();

        return redirect()->back()->with('success', 'User deleted successfully.');
    }

    public function show()
    {
        $user = Auth::user();  // Get the logged-in user
        return view('profile', compact('user'));
    }
    public function update(Request $request)
    {
        $user = Auth::user();  // Get the logged-in user

        // Validate the incoming data
        $validate = $request->validate([
            'fname' => 'required|string|max:255',
            'mname' => 'nullable|string|max:255',
            'lname' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'password' => 'nullable|confirmed|min:8',
        ]);

        // Update the user data except for the password
        $user->update($request->except('password'));

        // If password is provided, hash it and update
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
            $user->save();  // Save the updated password
        }

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }
}
