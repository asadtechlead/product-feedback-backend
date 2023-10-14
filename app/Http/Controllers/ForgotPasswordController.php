<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Mail\PasswordResetMail;
class ForgotPasswordController extends Controller
{
    public function sendResetLinkEmail(Request $request) {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $token = Str::random(60);
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => now(),
        ]);

        Mail::to($request->email)->send(new PasswordResetMail($token));

        return response(['message' => 'Reset link sent to your email.']);
    }
}
