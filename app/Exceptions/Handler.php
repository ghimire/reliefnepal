<?php namespace App\Exceptions;

use App\Http\ApiResponse;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Response;
use RuntimeException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler {

	/**
	 * A list of the exception types that should not be reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
		'Symfony\Component\HttpKernel\Exception\HttpException'
	];

	/**
	 * Report or log an exception.
	 *
	 * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
	 *
	 * @param  \Exception  $e
	 * @return void
	 */
	public function report(Exception $e)
	{
		return parent::report($e);
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Exception  $e
	 * @return \Illuminate\Http\Response
	 */
	public function render($request, Exception $e)
	{
        if($e instanceOf ModelNotFoundException)
        {
            $errorResponse = [
                "status" => 403,
                'message'   => $e->getMessage(),
                'errors'    => [],
            ];
            return ApiResponse::errorInternal($errorResponse);
        } elseif($e instanceOf RuntimeException) {
            $errorResponse = [
                "status" => 500,
                'message'   => $e->getMessage(),
                'errors'    => [],
            ];
            return ApiResponse::errorInternal($errorResponse);
        }
        /* elseif ($e) {
            $errorResponse = [
                "status" => 500,
                'message'   => $e->getMessage(),
                'errors'    => [],
            ];
            return ApiResponse::errorInternal($errorResponse);
        }*/

        return parent::render($request, $e);
	}
}