<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\View;
use App\Mail\WelcomeMail;
use App\Models\User;
use Illuminate\Http\Request;
use DateTime;
use Illuminate\Support\Facades\Auth;
use App\Events\UserSessionChanged;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{

    public function validateEmail($email)
    {
        $patternEmail = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
        return preg_match($patternEmail, $email);
    }

    public function calculateAge($birthdate)
    {
        $birthday = new DateTime($birthdate);
        $minAge = new DateTime('-14 years');
        return ($birthday <= $minAge);
    }

    public function showFormRegister()
    {
        return view('auth.register');
    }


    public function register(Request $request)
    {
        $user = new User();
        $user->name = $request->username;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->birth = $request->birth;
        $user->gender = $request->gender;
        $user->verify_code = mt_rand(10000, 99999);
        $user->sendcode_time = now();

        $err = [];

        if (empty($user->name) || empty($user->email) || empty($user->password) || empty($user->birth) || empty($user->gender)) {
            $err[] = 'Please enter all required information!';
        } else {
            if (!$this->validateEmail($user->email)) {
                $err['email'] = 'Please enter a valid email address!';
            }

            if ($user->password && strlen($request->password) < 6) {
                $err['password'] = 'Password must be 6 characters or more!';
            }

            if (!$this->calculateAge($user->birth)) {
                $err['birth'] = 'You must be at least 14 years old to create an account!';
            }

            $emailExists = User::where('email', $user->email)->exists();
            if ($emailExists) {
                $err['email'] = 'Account already in use!';
            }
        }

        if (empty($err)) {
            $user->save();
            Mail::to($user->email)->send(new WelcomeMail($user->verify_code, $user->name));
            session(['verify_email' => $user->email]);
            return redirect()->route('showVerifyForm');
        } else {
            return redirect()->route('show-form-register')->withErrors($err)->withInput();
        }
    }

    public function showFormLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials, $request->has('remember'))) {
            $user = User::find(Auth::id());

            if ($user->is_verify == 0) {
                $userVerify = User::find($user->id);
                $userVerify->verify_code = mt_rand(10000, 99999);
                $userVerify->sendcode_time = now();
                $userVerify->save();

                Mail::to($userVerify->email)->send(new WelcomeMail($userVerify->verify_code, $user->name));

                session(['verify_email' => $userVerify->email]);

                return redirect()->route('showVerifyForm');
            } else {
                if ($request->has('remember') && !$user->getRememberToken()) {
                    $user->setRememberToken(Str::random(60));
                    $user->save();
                }

                if ($user) {
                    event(new UserSessionChanged($user, "<i class='bx bxs-circle text-[12px] text-green-500'></i>"));
                }

                $user->status = 'online';
                $user->save();

                if ($user->role === 'admin') {
                    return redirect()->route('admin.home');
                } else {
                    return redirect()->route('show-home');
                }
            }
        }

        return redirect()->route('show-form-login')->withInput()->with('error', 'Incorrect account or password!');
    }




    public function logout()
    {
        $user = User::find(Auth::id());

        $user->status = 'offline';
        $user->save();

        Auth::logout();

        if ($user) {
            event(new UserSessionChanged($user, "<i class='bx bxs-circle text-[12px] text-red-500'></i>"));
        }

        return redirect()->route('show-form-login')->with('success', 'Logged out successfully');
    }
}
