<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

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
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (Throwable $e) {
            return $this->handleException($e);
        });
    }

    /**
     * Check what exception throws
     *
     * @param Throwable $e
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleException(Throwable $e) {
        $status = null;
        $data = null;
        $code = null;
        if ($e instanceof ValidationException) {
            $status = 'fail';
            $data = $e->errors();
            $code = Response::HTTP_UNPROCESSABLE_ENTITY;
        } elseif ($e instanceof ModelNotFoundException or $e instanceof NotFoundHttpException) {
            $status = 'fail';
            $data = $e->getMessage();
            $code = Response::HTTP_BAD_REQUEST;
        } elseif ($e instanceof Exception) {
            $status = 'error';
            $data = $e->getMessage();
            $code = Response::HTTP_BAD_REQUEST;
        }
        return $this->errorResponse($status, $data, $code);
    }

    /**
     * Set the json response that will return
     *
     * @param $status
     * @param $data
     * @param $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function errorResponse($status, $data, $code) {
        return response()->json([
            'status' => $status,
            'data' => $data
        ], $code);
    }

}
