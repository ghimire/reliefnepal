<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Offline\Settings\Facades\Settings;

class System extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'settings';

    public static function get($key){
        return Settings::get($key);
    }

    public static function set($key, $value){
        Settings::set($key, $value);
        return array($key, $value);
    }

    public static function forget($key){
        Settings::forget($key);
        return null;
    }

    public static function getAll(){
        $settings = System::all();

        $config = array();
        foreach($settings as $s){
            $config[$s->key] = unserialize($s->value);
        }
        return $config;
    }

    public static function flush(){
        Settings::flush();
        return null;
    }
}
