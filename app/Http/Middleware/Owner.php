<?php namespace App\Http\Middleware;

use App\Http\ApiResponse;
use Auth;
use Closure;

class Owner {

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
        $user_id = Auth::id();
        $request_id = $request->input('id');

        if(!$user->is_admin() || $user_id !== $request_id){
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
