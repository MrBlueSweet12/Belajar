<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
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
     */
    public function register()
    {
        $this->renderable(function (Throwable $e, $request) {
            if ($request->expectsJson()) {
                // Validation errors
                if ($e instanceof ValidationException) {
                    return response()->json([
                        'message' => 'Validation failed',
                        'errors' => $e->errors(),
                    ], 422);
                }
                // Authentication errors
                if ($e instanceof AuthenticationException) {
                    return response()->json([
                        'message' => 'Unauthenticated',
                    ], 401);
                }
                // Database errors
                if ($e instanceof QueryException) {
                    return response()->json([
                        'message' => 'Database error',
                        'error' => $e->getMessage(),
                    ], 500);
                }
                // HTTP errors
                if ($e instanceof HttpException) {
                    return response()->json([
                        'message' => $e->getMessage() ?: 'HTTP error',
                    ], $e->getStatusCode());
                }
                // Other server errors
                return response()->json([
                    'message' => 'Server error',
                    'error' => $e->getMessage(),
                ], 500);
            }
        });
    }
}
