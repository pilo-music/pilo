<?php

if (!function_exists('get_image')) {
    function get_image($model, $column = "image")
    {
        if (isset($model) && !is_string($model)) {
            $image = $model[$column];
            if (!isset($image) || $image == "")
                return "";
            if (substr_count($image, 'http') == 0) {
                if (substr_count($image, 'storage') > 0) {
                    if (substr_count($image, '/storage') > 0) {
                        $image = config()->get('app.url') . $image;
                    } else
                        $image = config()->get('app.url') . '/' . $image;
                } else {
                    $image = config()->get('app.url') . '/storage/' . $image;
                }
            }

            return preg_replace("/ /", "%20", $image);
        }
        return "";
    }
}

if (!function_exists('is_past')) {
    function is_past($date, $time, $format = "%i")
    {
        $datetime1 = new DateTime(now());
        $datetime2 = new DateTime($date);

        $interval = $datetime1->diff($datetime2);
        if ($interval->format($format) > $time) {
            return true;
        }
        return false;
    }
}


if (!function_exists('setting')) {
    function setting($key, $default = null)
    {
        $setting = \App\Models\Setting::query()->where('key', $key)->first();
        if ($setting) {
            return $setting->value;
        }
        return $default;
    }
}
