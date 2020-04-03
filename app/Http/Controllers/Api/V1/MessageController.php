<?php

namespace App\Http\Controllers\Api\V1;


use App\Http\Controllers\Api\CustomResponse;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Morilog\Jalali\Jalalian;

class MessageController extends Controller
{

    public function index()
    {
        $user = auth()->user();
        $messages = $user->messages()->latest()->get();

        $return_info = [];
        foreach ($messages as $item) {
            $return_info[] = [
                'subject' => $item->subject,
                'text' => $item->text,
                'type' => $item->type,
                'created_at' => Jalalian::forge($item->created_at)->ago(),
                'sender' => $item->sender
            ];
        }
        return CustomResponse::create($return_info, "", true);
    }

    public function message(Request $request)
    {
        $request->validate([
            'subject' => 'required|max:191',
            'text' => 'required|max:300',
        ]);

        $user = auth()->user();

        $item = $user->messages()->create([
            'subject' => $request->subject,
            'text' => $request->text,
            'sender' => Message::SENDER_USER,
            'type' => Message::TYPE_IMAGE
        ]);

        return CustomResponse::create([
            'subject' => $item->subject,
            'text' => $item->text,
            'type' => $item->type,
            'created_at' => Jalalian::forge($item->created_at)->ago(),
            'sender' => $item->sender
        ], "", true);
    }

}
