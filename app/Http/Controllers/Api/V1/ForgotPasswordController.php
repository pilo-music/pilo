<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\CustomResponse;
use App\Http\Controllers\Controller;
use App\Http\Repositories\V1\User\UserRepo;
use App\Mail\PasswordResetRequest;
use App\Models\VerifyCode;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $user = User::query()->where('email', $request->email)->first();

        /**
         * create verify code
         */
        $code = mt_rand(100000, 999999);
        VerifyCode::create([
            'email' => $user->email,
            'code' => $code,
        ]);
        /**
         * send verify Code
         */

        Mail::to($user->email)->queue(new PasswordResetRequest($code));

        return CustomResponse::create(null, __("messages.verify_code_sent"), true);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|exists:users,email',
            'code' => 'required',
            'password' => 'required|min:6|confirmed'
        ]);

        $code = VerifyCode::query()->where('email', $request->email)
            ->where('code', $request->code)->first();
        if (!$code) {
            return CustomResponse::create(null, __("messages.verify_not_found"), false);
        }

        /**
         *
         * check code expired after 15 min
         *
         */
        if (is_past($code->created_at, 15)) {
            return CustomResponse::create(null, __("messages.verify_code_expired"), false);
        }

        $user = User::query()->where('email', $request->email)->first();

        $user->password = bcrypt($request->password);
        $user->save();

        auth()->login($user);
        $token = $user->createToken('Client token')->accessToken;
        return CustomResponse::create([
            'access_token' => $token,
            'user' => UserRepo::getInstance()->toJson()->setUser($user)->build(),
        ], '', true);
    }
}
