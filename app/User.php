<?php namespace App;

use Hash;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
//use Illuminate\Auth\Passwords\CanResetPassword;
//use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract { //, CanResetPasswordContract {

    use Authenticatable; //, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';
    public $hidden_fields = [
        'password', 'roles', 'active', 'last_login', 'remember_token', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id', 'email', 'password', 'org_id', 'created_at', 'updated_at', 'last_login', 'remember_token', 'roles'];
    protected $default_roles = ['admin', 'user'];

    /**
     * @return bool
     */
    public function has_role($role) {
        $current_role = $this->roles;
        return $current_role == $role;
    }

    public function is_admin() {
        return $this->has_role('admin');
    }

    public function has_valid_roles($roles){
        return in_array($roles, $this->default_roles);
    }

    public function get_guarded(){
        return $this->guarded;
    }

    public function get_hidden(){
        return $this->hidden;
    }

    public function setPassword($password){
        $this->password = Hash::make($password);
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
