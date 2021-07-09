<?php

namespace App\Exceptions;

use App\Http\Controllers\Api\CustomResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {

        $this->renderable(function (ValidationException $exception, Request $request) {
            if ($request->expectsJson()) {
                $message = "";
                foreach ($exception->errors() as $item) {
                    foreach ($item as $error) {
                        $message .= $error;
                        break;
                    }
                    break;
                }

                return CustomResponse::create(null, $message, false);
            }
        });

        $this->renderable(function (ModelNotFoundException $e, Request $request) {
            if ($request->expectsJson()) {
                return CustomResponse::create(null, __("http.not_found"), false);
            }
        });

        $this->renderable(function (NotFoundHttpException $e, Request $request) {
            if ($request->expectsJson()) {
                return CustomResponse::create(null, __("http.not_found"), false);
            }
        });

        $this->renderable(function (HttpException $e, Request $request) {
            if ($request->expectsJson()) {
                return CustomResponse::create(null, __("http.server_error"), false);
            }
        });
    }
}
