<?php namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\DB;

abstract class Controller extends BaseController {

	use DispatchesCommands, ValidatesRequests;

    public $default_entries = 100;
    public $order_by = '';
    public $sort = 'asc';

    public function __call($method, $parameters)
    {
        return response("Not Found", 404);
    }

    public function enableQueryLog(){
        DB::enableQueryLog();
    }

    public function printQueryLog(){
        $queries = DB::getQueryLog();
        $last_query = end($queries);
        error_log(serialize($last_query));
    }

}
