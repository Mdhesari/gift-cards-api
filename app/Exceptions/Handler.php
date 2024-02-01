<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        $response = parent::render($request, $e);

        if ($request->wantsJson()) {
            if ($e instanceof BadRequestHttpException) {

                return response()->json([
                    'error' => $e->getMessage(),
                ], Response::HTTP_BAD_REQUEST);
            }

            if ($e instanceof NotFoundHttpException || $e instanceof ModelNotFoundException) {
                return response()->json([
                    'message' => $e->getMessage(),
                ], Response::HTTP_NOT_FOUND);
            }
        }

        return $response;
    }
}
