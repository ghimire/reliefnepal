<?php namespace App\Http\Controllers;

use App\Http\ApiResponse;
use App\System;
use App\Http\Requests;
use Illuminate\Http\Request;
use RuntimeException;


class SettingsController extends Controller {

    /**
     * Instantiate a new UserController instance.
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
	public function index(Request $request)
	{
        return ApiResponse::success(System::getAll());
	}

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
	public function store(Request $request)
	{
        if (!$request->has('key') || !$request->has('value'))
        {
            $errorResponse = [
                "status" => 403,
                'message'   => "Please check your input.",
                'errors'    => [],
            ];
            return ApiResponse::errorForbidden($errorResponse);
        }

        System::set($request->input('key'), $request->input('value'));
        return ApiResponse::json(System::get($request->input('key')));
	}

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @param Request $request
     * @return Response
     */
    public function show($key, Request $request)
    {
        if(($key == 'au_cities' || $key == 'np_cities') && $request->has('q')){
            $matches = [];
            $needle = strtoupper($request->input('q'));
            error_log($needle);
            foreach(System::get($key) as $index => $string) {
                if ($needle === "" || strrpos(strtoupper($string), $needle, -strlen(strtoupper($string))) !== FALSE){
                    array_push($matches, $string);
                }
            }
            return ApiResponse::json($matches);
        }

        return ApiResponse::json(System::get($key));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @param Request $request
     * @return Response
     */
	public function destroy($key, Request $request)
	{
        System::forget($request->input('key'));
        return ApiResponse::json(System::get($request->input('key')));
	}


}
