<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\CustomResponse;
use App\Http\Controllers\Controller;
use App\Models\UserNotification;
use Morilog\Jalali\Jalalian;

class NotificationController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $notifications = UserNotification::query()->where('user_id', $user->id)
            ->orWhereNull('admin_id')->take(20)->get();

        $data = [];

        foreach ($notifications as $notification) {
            $data[] = [
                'id' => $notification->id,
                'message' => $notification->message ?? "",
                'title' => $notification->title ?? "",
                'url' => $notification->url ?? "",
                'image' => get_image($notification),
                'created_at' => Jalalian::forge($notification->created_at)->ago(),
                'is_read' => $notification->is_read,
                'type' => $this->getType($notification->type),
            ];
            $notification->update([
                'is_read' => 1,
            ]);
        }

        return CustomResponse::create($data, '', true);
    }

    private function getType($type)
    {
        if ($type == UserNotification::TYPE_MUSIC) {
            return "music";
        }

        if ($type == UserNotification::TYPE_ALBUM) {
            return "album";
        }

        if ($type == UserNotification::TYPE_ARTIST) {
            return "artist";
        }

        if ($type == UserNotification::TYPE_PLAYLIST) {
            return "playlist";
        }

        if ($type == UserNotification::TYPE_URL) {
            return "url";
        }

        return "url";
    }
}
