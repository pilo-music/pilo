<?php

if (!function_exists('get_image')) {
    function get_image($model, $column = "image")
    {
        if (isset($model) && !is_string($model)) {
            $image = $model[$column];
            if (!isset($image) || $image == "") {
                return "";
            }
            if (substr_count($image, 'http') == 0) {
                if (substr_count($image, 'storage') > 0) {
                    if (substr_count($image, '/storage') > 0) {
                        $image = config()->get('app.url') . $image;
                    } else {
                        $image = config()->get('app.url') . '/' . $image;
                    }
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
        return $interval->format($format) > $time;
    }
}


if (!function_exists('setting')) {
    function setting($key, $default = null)
    {
        $setting = \App\Models\Setting::query()->where('key', $key)->first();
        return $setting->value ?? $default;
    }
}


if (!function_exists("get_ip")) {
    function get_ip()
    {
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip); // just to be safe
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                        return $ip;
                    }
                }
            }
        }
        return "";
    }
}

if (!function_exists('generate_slug')) {
    function generate_slug($string, $separator = '-', $limit = 100)
    {
        $string = str_replace('‌', ' ', $string);
        $string = \Illuminate\Support\Str::words($string, $limit, '');
        $string = mb_ereg_replace('([^آ-ی۰-۹a-z0-9]|-)+', $separator, $string);
        return trim($string, $separator);
    }
}

if (!function_exists('flash')) {
    function flash($message, $class)
    {
        session()->flash('admin_message_text', $message);
        session()->flash('admin_message_class', $class);
    }
}

if (!function_exists("is_local")) {
    function is_local(): bool
    {
        return config('app.env') === "local";
    }
}
