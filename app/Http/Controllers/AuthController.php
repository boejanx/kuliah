<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\PasswordReset;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        if($request->isMethod('get')) {
            return view('auth.register');
        }

        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $user  = new User();
        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->password = Hash::make($request['password']);
        $user->save();

        event(new Registered($user));

        //return redirect()->route('verification.notice');

    }

    public function login(Request $request)
    {
        if($request->isMethod('get')) {
            return view('auth.login');
        }

        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('stuffs.index');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');

    }

    public function forgotPassword(Request $request)
    {
        if($request->isMethod('get')) {
            return view('auth.forgot');
        }

        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if(!$user) {
            return view('auth.forgot', ['error' => 'The email given is not found']);
        }

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if($status !== Password::RESET_LINK_SENT) {
            back()->withErrors('email', __($status));
        }

        return view('auth.forgot', ['success' => 'Check your email and click the reset link!']);

    }

    function resetPassword(Request $request, $token=null ){
        if($request->isMethod('get')) {
            return view('auth.reset_password', ['token' => $token]);
        }

        $request->validate([
            'token' => 'required',
            'email' => 'required|string|email',
            'password' => 'required|string|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();

                event( new PasswordReset($user));
            }
        );

        if($status == Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', __($status));
        } else {
            return redirect()->route('password.reset', ['token' => $token])->withErrors(['email' => __($status)]);
        }
    }


    public function logout(Request $request)
    {
        Auth::logout(); // Menghapus sesi pengguna

        $request->session()->invalidate(); // Menghapus sesi
        $request->session()->regenerateToken(); // Membuat token CSRF baru

        return redirect('/'); // Redirect ke halaman login setelah logout
    }
}
