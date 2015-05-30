<?php namespace App;

use App\Http\Helpers;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'organizations';
    public $hidden_fields = ['comment', 'status', 'created_at', 'updated_at',];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id', 'slug', 'name', 'profile_picture', 'created_at', 'updated_at'];

    public function truncateName() {
        $name = $this->name;
        $limit = 30;
        if(empty($name)){
            $name = "Unknown Company";
        }
        if(strlen($name) <= $limit){
            return $name . str_repeat("&nbsp; ", ($limit - strlen($name)) * 1);
        }
        return  (strlen($name) > $limit) ? substr($name,0, $limit).'…' : $name;
    }

    public function truncateDescription() {
        $description = $this->description;
        $limit = 120;
        if(empty($description)){
            $description = "Description is currently unavailable.";
        }
        if(strlen($description) <= $limit){
            return $description . str_repeat("&nbsp; ", $limit - strlen($description));
        }
        return  (strlen($description) > $limit) ? substr($description,0, $limit).'…' : $description;
    }

    public function getUrl(){
        return Helpers::get_full_domain() . '/v/' . $this->slug;
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'id', 'org_id');
    }

    public function activities()
    {
        return $this->hasMany('App\Activity', 'org_id', 'id');
    }

}
