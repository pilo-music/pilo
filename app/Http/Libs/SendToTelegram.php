<?php

namespace App\Libs;

use App\Models\Album;
use App\Models\Music;
use App\Models\Video;
use Toolkito\Larasap\SendTo;

class SendToTelegram
{
    public static function send($model, $type)
    {
        if ($model instanceof Album){
            $model_type = "آلبوم";
            $link = BitlyShortLink::generate("https://pilo.app/album/{$model->slug}");
        }elseif ($model instanceof Music){
            $model_type = "موزیک";
            $link = BitlyShortLink::generate("https://pilo.app/music/{$model->slug}");
        }else{
            $model_type = "موزیک ویدیو";
            $link = BitlyShortLink::generate("https://pilo.app/video/{$model->slug}");
        }

        if ($link != null && $link != "") {
            $ar_name = str_replace('-', '_', $model->artist->slug);
            $text = " \r\n\r\n 🎼 $model_type ( $type ) و زیبای #{$ar_name}" . " به نام" . " \"{$model->title}\" \r\n\r\n 📥 برای گوش دادن و دانلود روی لینک زیر کلیک کنید. \r\n\r\n {$link} \r\n\r\n 🆔 @pilomusic";
            SendTo::Telegram(
                $text, [
                'type' => 'photo',
                'file' => $model->image,
            ],
                [
                    [
                        [
                            'text' => ' 👤 صفحه خواننده',
                            'url' => "https://pilo.app/artist/{$model->artist->slug}"
                        ]
                    ],
                ]
            );
        }
    }

}
