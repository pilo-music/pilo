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
        $request->validate([
            'pic' => 'is_image'
        ]);

        $user = auth()->user();
        if ($request->has('pic')) {
            $img = Image::make($request->get('pic'));
            $img->resize(300, 300);
            $img->encode('jpg');
            $fileName = now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($request->get('pic'), 0, strpos($request->get('pic'), ';')))[1])[1];
            Storage::disk('custom-ftp')->put('public_html/profile/' . $fileName, $img);
            $imageUrl = env('APP_URL', 'https://pilo.app') . '/profile/' . $fileName;
        } else
            $imageUrl = $user->pic;

        if ($request->has('name') && strlen($request->name) > 2)
            $name = $request->name;
        else
            $name = $user->name;

        if ($request->has('password') && strlen($request->name) > 5)
            $password = bcrypt($request->password);
        else
            $password = $user->password;

        $user->update([
            'pic' => $imageUrl,
            'name' => $name,
            'password' => $password
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
