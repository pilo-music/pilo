<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\CustomResponse;
use App\Http\Controllers\Controller;
use App\Http\Repositories\V1\User\UserRepo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{

    public function update(Request $request)
    {
        $user = auth()->user();

        if ($request->has('password')) {
            $request->validate([
                'password' => 'required|confirmed|min:6',
            ]);
            $password = bcrypt($request->password);
        } else {
            $password = $user->password;
        }

        if ($request->has('pic')) {
            $img = Image::make($request->get('pic'));
            if ($img) {
                $img->resize(300, 300);
                $img->encode('jpg');
                $fileName = now()->timestamp . '_' . uniqid('', true) . '.' . 'jpg';
                Storage::disk('custom-ftp')->put('public_html/profile/' . $fileName, $img);
                $imageUrl = env('APP_URL', 'https://pilo.app') . '/profile/' . $fileName;
            } else {
                $imageUrl = $user->pic;
            }
        } else
            $imageUrl = $user->pic;


        $user->update([
            'pic' => $imageUrl,
            'name' => $request->name ?? $user->name,
            'password' => $password,
            'global_notification' => $request->global_notification ?? $user->global_notification,
            'music_notification' => $request->music_notification ?? $user->music_notification,
            'album_notification' => $request->album_notification ?? $user->album_notification,
            'video_notification' => $request->video_notification ?? $user->video_notification,
        ]);

        return CustomResponse::create(UserRepo::getInstance()->toJson()->setUser($user)->build(), __('messages.profile_update_successfully'), true);
    }


    /**
     * Get the authenticated User.
     *
     * @return JsonResponse
     */
    public function me()
    {
        $user = auth()->user();
        return CustomResponse::create(UserRepo::getInstance()->toJson()->setUser($user)->build(), '', true);
    }

}
