<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\CustomResponse;
use App\Http\Controllers\Controller;
use App\Http\Repositories\V1\User\UserRepo;
use App\Jobs\SendVerifyCode;
use App\Models\User;
use App\Models\VerifyCode;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Get a JWT via given credentials.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'phone' => 'required|size:11',
        ]);

        $phone = $request->get('phone');
        $code = random_int(100000, 999999);
        VerifyCode::query()->create([
            'phone' => $request->get('phone'),
            'code' => bcrypt($code)
        ]);

        SendVerifyCode::dispatch($phone, $code);

        return CustomResponse::create(null, '', true);
    }

    public function verify(Request $request): JsonResponse
    {
        $request->validate([
            'phone' => 'required|size:11',
            'code' => 'required|integer|min:100000|max:999999',
        ]);

        /**
         * check verify code exists
         */
        $verifyCode = VerifyCode::query()
            ->where('phone', $request->phone)
            ->latest()
            ->first();

        if (!$verifyCode) {
            return CustomResponse::create(null, __('messages.verify_not_found'), false);
        }

        if (!Hash::check($request->code, $verifyCode->code)) {
            return CustomResponse::create(null, __('messages.verify_not_found'), false);
        }


        /**
         * check code expired after 15 min
         */
        if (is_past($verifyCode->created_at, 15)) {
            $verifyCode->delete();
            return CustomResponse::create(null, __("messages.verify_code_expired"), false);
        }

        $user = User::query()->where('phone', $verifyCode->phone)->firstOrNew();
        $user->phone = $request->phone;
        $user->status = User::USER_STATUS_ACTIVE;
        $user->phone_verified_at = now();
        $user->save();


        /**
         * delete verify code
         */
        $verifyCode->delete();

        $token = $user->createToken('Client token')->plainTextToken;
        return CustomResponse::create([
            'access_token' => $token,
            'user' => UserRepo::getInstance()->toJson()->setUser($user)->build(),
        ], '', true);
    }
}
