<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Exception;
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
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Throwable $exception)
    {
        if ($exception instanceof \League\OAuth2\Server\Exception\OAuthServerException && $exception->getCode() == 9) {
            return;
        }
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $exception)
    {
        // dd($exception);
        // dd($exception->getMessages());
     //    if($exception->getMessages() == 'Unauthenticated.'){
     //     return Response()->json(['success'=> false,'message' => "Do not have authorized to access this route."],403);
     // }
        // dd($exception->getStatusCode());
       //  if ($exception instanceof NotFoundHttpException) {
       //     return response()->json([
       //      'error' => 'Resource not found'
       //  ], 404);

       // }
       // if ($exception instanceof MethodNotAllowedHttpException) {
       //     return response()->json([
       //      'error' => 'Resource not found'
       //  ], 404);
       // }
        if ($this->isHttpException($exception)) {
            switch ($exception->getStatusCode()) {

                // not authorized
                case '403':
                return Response()->json(['success'=> false,'message' => "Do not have authorized to access this route."],403);
                break;

                // not found
                case '404':
                return Response()->json(['success'=> false,'message' => "Api not found."],404);
                break;

                // internal error
                case '500':
                return Response()->json(['success'=> false,'message' => "Internal server error."],500);
                break;

                case '405':
                return Response()->json(['success'=> false,'message' => "Method Not Allowed."],405);
                break;

                default:
                return $this->renderHttpException($exception);
                break;
            }
        }
        else {
            return parent::render($request, $exception);
        }
 }
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
    protected function unauthenticated($request, AuthenticationException $exception) 
    {
        
        return response()->json(['success'=> false,'message' => 'Session expired please relogin.'], 401);
        // dd($request->expectsJson());
        //401 Unauthorized
        return $request->expectsJson()
        ? response()->json(['success'=> false,'message' => 'Session expired please relogin.'], 401)
        : redirect()->guest($exception->redirectTo() ?? route('login'));
    }
}
