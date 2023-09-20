<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\VerifyLoginRequest;
use App\Http\Requests\Api\User\ProfileUpdateRequest;
use App\Http\Requests\Api\User\UserLoginRequest;
use App\Http\Requests\Api\User\UserRequest;
use App\Http\Requests\Api\User\VerifyPhoneRequest;
use App\Http\Requests\Api\User\ResendVerifyPhoneRequest;
use App\Http\Resources\Api\User\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
//    public function __construct()
//    {
//        $this->middleware('auth');
//    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function login(UserLoginRequest $request)
    {
        $data = $request->validated();
        $user = User::where('country_code', $data['country_code'])->where('phone', $data['phone'])->first();

        if (!$userToken = JWTAuth::fromUser($user)) {
            return msg(false, trans('lang.invalid_account'), failed());
        }

//        if ($user->email_verified_at == null) {
//            $user->logout();
//            return msg(false, trans('lang.verify_phone_first'), not_accepted());
//        }
//        if ($user->status == 'inactive') {
//            auth('user')->logout();
//            return msg(false, trans('lang.you_not_active_contact_admin'), not_accepted());
//        }

        if (config('app.env') == 'local') {
            $code = 9999;
        } else {
            $code = $token = rand(1000, 9999);
        }


        $user->login_code = $code;
        $user->save();

        $result['otp'] = (int)$code;
//        TODO SMS send function here...

        return msgdata(true, trans('lang.code_sent'), $result, success());
    }

    public function verifyLogin(VerifyLoginRequest $request)
    {
        $data = $request->validated();
        $exist_user = User::where('country_code', $data['country_code'])->where('phone', $data['phone'])->
        where('login_code', $data['token'])->first();
        if ($exist_user) {
            $token = Auth::guard('user')->login($exist_user);
            if (!$token) {
                return msg(false, trans('lang.invalid_account'), failed());
            }
//            if (Auth::guard('user')->user()->email_verified_at == null) {
//                auth('user')->logout();
//                return msg(false, trans('lang.verify_phone_first'), failed());
//            }

            $result['token'] = $token;
            $result['user_data'] = Auth::guard('user')->user();
//        update fcm_token if sent it
            if (isset($data['fcm_token'])) {
                Auth::guard('user')->user()->update(['fcm_token' => $data['fcm_token']]);
            }
            $exist_user->login_code = null;
            $exist_user->save();
            return msgdata(true, trans('lang.login_s'), $result, success());
        } else {
            return msg(false, trans('lang.otp_invalid'), failed());

        }
    }

    public function register(UserRequest $request)
    {
        $data = $request->validated();
        $user = User::create($data);
        //sending otp to user
        $phone = $data['country_code'] . '' . $data['phone'];
        $otp = \Otp::generate($phone);
        if (env('APP_ENV') == 'local') {
            $otp = "9999";
        }
        $result['otp'] = $otp;

        return msgdata(true, trans('lang.sign_up_success'), $result, success());
    }

    public function verifyPhone(VerifyPhoneRequest $request)
    {
        $data = $request->validated();

        $phone = $data['country_code'] . '' . $data['phone'];

        if (env('APP_ENV') == 'local') {
            if ($data['otp'] == '9999') {
                $client = User::where('country_code', $data['country_code'])->where('phone', $data['phone'])->first();
                if ($client) {
                    $client->email_verified_at = Carbon::now();
                    $client->save();
                    return msg(true, trans('lang.phone_verified_s'), success());
                } else {
                    return msg(false, trans('lang.client_not_found'), failed());
                }
            } else {
                return msg(false, trans('lang.otp_invalid'), failed());
            }
        } else {
            $validated_otp = \Otp::validate($phone, $data['otp']);

            if ($validated_otp->status == true) {
                $client = User::where('country_code', $data['country_code'])->where('phone', $data['phone'])->first();
                if ($client) {
                    $client->email_verified_at = Carbon::now();
                    $client->save();
                    return msg(true, trans('lang.phone_verified_s'), success());
                } else {
                    return msg(false, trans('lang.client_not_found'), failed());
                }
            } else {
                return msg(false, trans('lang.otp_invalid'), failed());

            }
        }

    }

    public function resendVerifyPhone(ResendVerifyPhoneRequest $request)
    {
        $data = $request->validated();

        $phone = $data['country_code'] . '' . $data['phone'];
        $otp = \Otp::generate($phone);
        if (env('APP_ENV') == 'local') {
            $otp = "9999";
        }
        $result['otp'] = $otp;
        //TODO :send sms to phone number ...
        //Smsmisr::send("كود التحقق الخاص بك هو: " . $otp, $request->phone, null, 2);
        //sendSMS2($request->phone,$otp);
        //end sending
        return msgdata(true, trans('lang.code_send_again_s'), $result, success());
    }

    public function profile()
    {
        $client = (new UserResource(Auth::guard('user')->user()));
        return msgdata(true, trans('lang.data_display_success'), $client, success());
    }

    public function profileUpdate(ProfileUpdateRequest $request)
    {
        $data = $request->validated();
        if (isset($data['image']) && is_file($data['image'])) {
            $data['image'] = upload($data['image'], 'clients_images');
        }
        User::where('id', \auth('user')->user()->id)->update($data);
        return msg(true, trans('lang.data_updated_s'), success());
    }






    /**
     * Write code on Method
     *
     * @return response()
     */

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function submitForgetPasswordForm(Request $request)
    {
        $request->validate([
            'country_code' => 'required|string',
            'phone' => 'required|exists:users,phone',
        ]);

        if (env('APP_ENV') == 'local') {
            $token = "9999";
        } else {
            $token = rand(1000, 9999);
        }
        DB::table('user_password_rest')->insert([
            'country_code' => $request->country_code,
            'phone' => $request->phone,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);
        //TODO will make here send sms to client phone ...

        //  Mail::send('email.forgetPassword', ['token' => $token], function($message) use($request){
        //     $message->to($request->email);
        //   $message->subject('Reset Password');
        //    });
        $result['otp'] = (string)$token;

        return msgdata(true, trans('lang.email_sent'), $result, success());
    }
    /**
     * Write code on Method
     *
     * @return response()
     */

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function submitResetPasswordForm(Request $request)
    {
        $request->validate([
            'country_code' => 'required|string',
            'phone' => 'required|exists:users,phone',
            'token' => 'required|numeric',
        ]);
        $updatePassword = DB::table('user_password_rest')
            ->where([
                'country_code' => $request->country_code,
                'phone' => $request->phone,
                'token' => $request->token
            ])
            ->first();
        if (!$updatePassword) {
            return msgdata(true, trans('lang.token_invalid'), (object)[], failed());
        }
        $client = User::where('country_code', $request->country_code)->where('phone', $request->phone)->first();
        $token = auth('user')->login($client);
        if (!$token) {
            return msg(false, trans('lang.unauthorized'), failed());
        }
        $result['token'] = $token;
        $result['client_data'] = Auth::guard('user')->user();
        DB::table('user_password_rest')->where(['phone' => $request->phone])->delete();
        return msgdata(true, trans('lang.possword_rest'), $result, success());
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'nullable|string',
            'password' => 'required|string|min:6|confirmed',
        ]);
        $client = auth('user')->user();
        if ($request->old_password) {
            if ($request->old_password) {
                $old_password = Hash::check($request->old_password, $client->password);
                if ($old_password != true) {
                    return msg(false, trans('lang.old_passwordError'), failed());
                }
            }
        }
        User::where('id', $client->id)
            ->update(['password' => bcrypt($request->password)]);
        return msg(true, trans('lang.password_changed_s'), success());
    }

    public function logout(Request $request)
    {
        auth('user')->logout();
        return msg(true, trans('lang.logout_s'), success());
    }
}

