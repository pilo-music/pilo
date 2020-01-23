<?php

if (!function_exists('get_image')) {
    function get_image($model, $column = "image")
    {
        if (isset($model) && !is_string($model)) {
            $image = $model[$column];
            if (!isset($image) || $image == "")
                return "";
            if (substr_count($image, 'storage') > 0) {
                if (substr_count($image, '/storage') > 0) {
                    $image = config()->get('app.url') . $image;
                } else
                    $image = config()->get('app.url') . '/' . $image;
            } else {
                $image = config()->get('app.url') . '/storage/' . $image;
            }

            return preg_replace("/ /", "%20", $image);
        }
        return "";
    }
}
