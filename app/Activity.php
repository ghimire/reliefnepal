<?php namespace App;

use App\Http\Helpers;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'activities';
    public $hidden_fields = ['created_at', 'updated_at',];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id', 'org_id', 'created_at', 'updated_at'];

    public function truncateName() {
        $name = $this->name;
        $limit = 30;
        if(empty($name)){
            $name = "Unknown Activity";
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
        return Helpers::get_full_domain() . '/activities/' . $this->id;
    }

    public function organization()
    {
        return $this->hasOne('App\Organization', 'id', 'org_id');
    }

    public function toArray(){
        $array = parent::toArray();
        $array['organization']['name'] = $this->organization->name;
        return $array;
    }

}
