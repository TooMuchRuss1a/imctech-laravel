<?php

namespace App\Exceptions;

use App\Models\Error;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
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
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        $retval = parent::render($request, $exception);

        if (env('CUSTOM_LOG')) $this->logError($request, $exception);

        return $retval;
    }

    protected function logError($request, $exception): void {
        $post = $request->post();
        unset($post['recaptcha']);
        unset($post['_token']);
        if (!empty($post['password'])) {
            $post['password'] = str_repeat("*", strlen($post['password']));
        }

        $data = [
            'status' => (method_exists($exception, 'getStatusCode')) ?  $exception->getStatusCode() : ((isset($exception->status)) ? $exception->status : 500),
            'username' => (auth()->check()) ? auth()->user()->login : 'unknown',
            'method' => $request->getMethod(),
            'uri' => $request->getRequestUri(),
            'where' => $exception->getFile() . ' ' . $exception->getLine(),
            'agent' => $request->header()['user-agent'][0],
            'message' => $exception->getMessage(),
            'data' => (!empty($post)) ? json_encode($post, JSON_UNESCAPED_UNICODE) : null,
        ];

        Error::create($data);
    }
}
