<?php namespace App\Http\Middleware;

use Auth;
use Closure;
use \ApiResponse;

class Admin {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
        $error_response = [
            "status" => 401,
            "message" => "Not Authorized.",
        ];

        if (!Auth::check()) {
            if ($request->isJson()){
                return ApiResponse::errorUnauthorized($error_response);
            } else {
                abort(401);
            }
        }

        $user = Auth::user();
        if(!$user->is_admin()){
            if ($request->isJson()){
                ApiResponse::errorUnauthorized($error_response);
            } else {
                abort(401);
            }
        } else {
            return $next($request);
        }
	}

}
