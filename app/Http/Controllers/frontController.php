<?php

namespace App\Http\Controllers;


use App\Http\Requests\Admin\AdminRequest;
use App\Models\Admin;
use App\Models\Page;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class frontController extends Controller
{

    public function home()
    {
        return view('Front.home');
    }

    public function pages($type)
    {
        $data = Page::where('type', $type)->first();
        return view('Front.pages', compact('type','data'));
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $remember_me = $request->has('remember_me') ? true : false;
        if (Auth::guard('admin')->attempt($credentials, $remember_me)) {
            // Authentication passed...
            return redirect()->intended('/');
        } else {
            return back()->with('danger', trans('lang.wrong_password'));
        }
    }

    public function logout()
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();

        }
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        }
        return redirect('/login')->with('message', 'success');
    }

    public function register()
    {
        return view('front.register');
    }


    function showForgetPasswordForm()
    {
        return view('auth.forget_password');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function submitForgetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:admins',
        ]);

        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        Mail::send('email.forgetPassword', ['token' => $token, 'email' => $request->email], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset Password');
        });

        return back()->with('success', trans('We have e-mailed your password reset link!'));
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function showResetPasswordForm($token, $email)
    {
        return view('auth.reset_password', ['token' => $token, 'email' => $email]);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function submitResetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:admins',
            'password' => 'required|string|min:6|confirmed',
        ]);
        $updatePassword = DB::table('password_resets')
            ->where([
                'email' => $request->email,
                'token' => $request->token
            ])
            ->first();
        if (!$updatePassword) {
            return back()->withInput()->with('error', 'Invalid token!');
        }
        User::where('email', $request->email)->update(['password' => $request->password]);
        DB::table('password_resets')->where(['email' => $request->email])->delete();
        return redirect('/login')->with('message', 'Your password has been changed!');
    }


}
