<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\CustomResponse;
use App\Http\Controllers\Controller;
use App\Http\Repositories\V1\User\UserRepo;
use App\Mail\VerifyMail;
use App\Models\User;
use App\Models\VerifyCode;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    /**
     * Get a JWT via given credentials.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:190',
            'password' => 'required'
        ]);

        /**
         * check user exists in db
         */
        $user = User::query()->where('email', trim($request->email))->first();
        if (!$user) {
            return CustomResponse::create(null, __('messages.wrong_email_password'), false);
        }

        /**
         * check password
         */

        if (!Hash::check($request->password, $user->password)) {
            return CustomResponse::create(null, __("messages.wrong_email_password"), false);
        }


        /**
         * check user status
         */

        if ($user->status != User::USER_STATUS_ACTIVE) {
            if ($user->status == User::USER_STATUS_DEACTIVE) {
                return CustomResponse::create(null, __("messages.account_ban"), false);
            }

            if ($user->status == User::USER_STATUS_NOT_VERIFY) {
                $code = VerifyCode::create([
                    'email' => $user->email,
                    'code' => mt_rand(100000, 999999),
                ]);
                Mail::to($user->email)->send(new VerifyMail($code->code));
                return CustomResponse::create([
                    'status' => 'verify'
                ], __("messages.verify_code_sent"), true);
            }
        }

        $token = $user->createToken('Client token')->accessToken;

        return CustomResponse::create([
            'access_token' => $token,
            'status' => 'login',
            'user' => UserRepo::getInstance()->toJson()->setUser($user)->build(),
        ], '', true);
    }


    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:190',
            'password' => 'required|confirmed|min:6',
            'name' => 'max:190'
        ]);

        if (User::query()->where('email', trim($request->email))->exists()) {
            return CustomResponse::create(null, __("messages.email_exists"), false);
        }

        $name = $request->name;
        if (!$request->name || $request->name == "") {
            $name = explode('@', $request->email)[0];
        }

        $user = User::query()->create([
            'name' => $name,
            'password' => bcrypt($request->password),
            'email' => $request->email
        ]);

        $code = VerifyCode::create([
            'email' => $user->email,
            'code' => mt_rand(100000, 999999),
        ]);
        Mail::to($user->email)->send(new VerifyMail($code->code));

        return CustomResponse::create(null, '', true);
    }

    public function verify(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:190',
            'code' => 'required',
        ]);

        /**
         * check verify code exists
         */
        $verifyCode = VerifyCode::query()->where('code', $request->code)
            ->where('email', $request->email)
            ->first();
        if (!$verifyCode) {
            return CustomResponse::create(null, __('messages.verify_not_found'), false);
        }

        /**
         * check code expired after 15 min
         */
        if (is_past($verifyCode->created_at, 15)) {
            $verifyCode->delete();
            return CustomResponse::create(null, __("messages.verify_code_expired"), false);
        }

        $user = User::query()->where('email', $verifyCode->email)->first();
        /**
         * update user info
         */
        $user->status = User::USER_STATUS_ACTIVE;
        $user->email_verified_at = now();
        $user->save();


        /**
         * delete verify code
         */
        $verifyCode->delete();


        $token = $user->createToken('Client token')->accessToken;
        return CustomResponse::create([
            'access_token' => $token,
            'user' => UserRepo::getInstance()->toJson()->setUser($user)->build(),
        ], '', true);
    }


    public function SocialSignup($provider)
    {
        // Socialite will pick response data automatic
        $user = Socialite::driver($provider)->stateless()->user();

        return response()->json($user);
    }

}
