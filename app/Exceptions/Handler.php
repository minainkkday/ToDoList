<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Validation\ValidationException;
use LogicException;
use Illuminate\Auth\AuthenticationException;


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
     * A list of the inputs that are never flashed to the session on validation exceptions.
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
    public function render($request, Throwable $e)
    {
        parent::render($request, $e);

        //This one works only!
        if ($e instanceof ValidationException) {
            $metadata = ['status' => '9999', 'desc'=>'Fail'];
            $responseData = ['metadata' => $metadata, 'data' => $e->validator->getMessageBag()->getMessages()];
            return response()->json($responseData, 400);
        } 

        //delete error handling, doens't work either
        if ($e instanceof LogicException) {
            $metadata = ['status' => '9999', 'desc'=>'Fail'];
            $responseData = ['metadata' => $metadata, 'data' => $e->getMessage()];
            return response()->json($responseData, 400);
        } 

        //Auth::attempt(), but somehow it doesn't work.
        if ($e instanceof AuthenticationException) {
            $metadata = ['status' => '9999', 'desc'=>'Fail'];
            $responseData = ['metadata' => $metadata, 'data' => $e->getMessage()];
            return response()->json($responseData, 400);
        } 
    }
}
