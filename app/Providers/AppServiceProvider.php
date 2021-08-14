<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('is_image', function ($attribute, $value, $params, $validator) {
            if ($value != "") {
                $result = mime_content_type($value);
                if ($result == 'image/png' || $result == 'image/jpg' || $result == 'image/jpeg') {
                    return true;
                }
            }
            return false;
        });
    }
}
