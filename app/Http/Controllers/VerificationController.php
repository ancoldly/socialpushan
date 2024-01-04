<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeMail;
use App\Mail\WelcomeMailPass;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class VerificationController extends Controller
{
    public function showVerifyForm()
    {
        return view("auth.verify");
    }

    public function showReset_password()
    {
        return view('auth.reset_password');
    }

    public function showVerifyPasswordForm(Request $request)
    {
        $errors = [];

        $email_request = $request->email_request;
        $user = User::where('email', $email_request)->first();

        if ($user) {
            $user->verify_code = mt_rand(10000, 99999);
            $user->save();
            Mail::to($user->email)->send(new WelcomeMailPass($user->verify_code, $user->name));

            return view("auth.verify_password", compact('email_request'));
        }

        $errors[] = 'Your account was not found';

        return redirect()->route('forgotten_password')->withErrors($errors);
    }


    public function forgotten_password()
    {
        return view("auth.forgotten_password");
    }

    public function verify(Request $request)
    {
        $request->validate([
            'verification_code' => 'required',
        ], [
            'verification_code' => 'Wrong data entered'
        ]);

        $user = User::where('email', $request->verify_email)->where('verify_code', $request->verification_code)->first();

        if ($user) {
            $user->is_verify = 1;
            $user->verify_code = null;
            $user->sendcode_time = now();
            $user->save();
            return redirect()->route('show-home')->with('success', 'Your account has been authentication success.');
        }

        return back()->withErrors(['verification_code' => 'Invalid authentication code.']);
    }

    public function verify_password(Request $request)
    {
        $request->validate([
            'verification_code' => 'required',
        ], [
            'verification_code' => 'Wrong data entered'
        ]);

        $user = User::where('email', $request->verify_email)->where('verify_code', $request->verification_code)->first();

        if ($user) {
            $user->verify_code = null;
            $user->sendcode_time = now();
            $user->save();
            session(['verify_email' => $user->email]);
            return redirect()->route('showReset_password');
        }

        return back()->withErrors(['verification_code' => 'Invalid authentication code.']);
    }

    public function reset_password(Request $request)
    {
        $user = User::where('email', $request->email_request)->first();

        $user->password = bcrypt($request->password_request);
        $user->verify_code = null;
        $user->sendcode_time = now();

        $user->save();

        return redirect()->route('show-form-login');
    }

    public function requestNewCode(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        $minutesSinceLastRequest = now()->diffInMinutes($user->sendcode_time);

        if ($minutesSinceLastRequest < 1) {
            return back()->withErrors(['verification_code' => 'Please wait a moment before requesting a new code.']);
        }
        $newVerificationCode = mt_rand(10000, 99999);
        $user->verify_code = $newVerificationCode;
        $user->sendcode_time = now();
        $user->save();

        Mail::to($user->email)->send(new WelcomeMail($newVerificationCode, $user->name));

        return back()->with('success', 'The new authentication code has been sent again.');
    }
}
