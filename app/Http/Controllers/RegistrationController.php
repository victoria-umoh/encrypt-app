<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class RegistrationController extends Controller
{
    public function showForm()
    {
        return view('registration');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|digits:11',
            'email' => [
                'required',
                'email',
                'regex:/^[a-zA-Z0-9._%+-]+@(gmail|yahoo)\.com$/',
                'unique:users,email'
            ],
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Mail::send('email.registration', ['user' => $user], function ($message) use ($user) {
            $message->to($user->email);
            $message->subject('Registration Confirmation');
        });

        return redirect()->back()->with('success', 'Registration successful! A confirmation email has been sent.');
    }
}
