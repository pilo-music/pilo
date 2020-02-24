<?php

namespace App\Http\Controllers\Api\V1;


use App\Http\Controllers\Api\CustomResponse;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Hekmatinasser\Verta\Verta;


class MessageController extends Controller
{
    public function add(Request $request)
    {
        $request->validate([
            'subject' => 'required',
            'text' => 'required',
            'type' => 'required',
        ]);

        $user = auth()->user();

        $user->messages()->create([
            'subject' => $request->subject,
            'text' => $request->text,
            'sender' => Message::SENDER_USER,
            'type' => $request->type
        ]);

        return CustomResponse::create(null, "", true);
    }

    public function list()
    {
        $user = auth()->user();
        $messages = $user->messages()->latest()->get();

        $return_info = [];
        foreach ($messages as $item) {
            $date = new Verta($item->created_at);
            $return_info[] = [
                'subject' => $item->subject,
                'text' => $item->text,
                'type' => $item->type,
                'created_at' => $date->formatDifference(),
                'sender' => $item->sender
            ];
        }
        return CustomResponse::create($return_info, "",true);
    }
}
