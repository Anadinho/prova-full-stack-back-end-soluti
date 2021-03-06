<?php

namespace App\Exceptions;


use App\Exceptions\Traits\ApiException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    use ApiException;
   
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

        // $this->renderable(function (Throwable $e) {
        //     $this->renderable(function (NotFoundHttpException $e, $request) {
        //         return response()->json(...);

        //         return 
        // });
    }

    

    /**
     * Render an exception into an HTTP response
     */
    // public function render($request, Throwable $exception)
    // {
    //     if($request->is('api/*'))
    //     {
    //         return $this->getJsonException($request, $exception);
           
    //     }

    //     return parent::render($request, $exception);
    // }

    
}

