<?php namespace App\Http\Controllers;

use App\Http\ApiResponse;
use App\Http\Helpers;
use App\User;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use RuntimeException;


class UsersController extends Controller {

    /**
     * Instantiate a new UserController instance.
     */
    public function __construct()
    {
        $this->middleware('admin', ['only' => ['index', 'store', 'destroy',]]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
	public function index(Request $request)
	{
        $users = User::orderBy('1', '1');

        if($request->has('q')){
            $needle = $request->input('q');
            $users = $users->where('email', 'like', $needle.'%');
        }

        if($request->has('order_by')){
            $this->order_by = $request->input('order_by');
            if($request->has('sort')) {
                $this->sort = $request->input('sort');
            }
        }

        $users = $users->orderBy($this->order_by, $this->sort)->paginate(
            ($request->has('entries_count') && intval($request->input('entries_count')) > 0)?$request->input('entries_count'):$this->default_entries
        );

        return ApiResponse::success($users);
	}

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
	public function store(Request $request)
	{
        $v = Validator::make($request->all(), $this->getRules($request));
        if ($v->fails()) { abort(403, $v->messages());}

        $this->check_admin_permission($request);

        $user = new User();
        $input = $request->all();
        $user->fill($input);
        $user->email = $request->input('email');
        $user->org_id = $request->input('org_id');
        $user->roles = $request->input('roles');
        $user->setPassword($request->input('password'));
        $user->save();

        return ApiResponse::created($user);
	}

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @param Request $request
     * @return Response
     */
	public function show($id, Request $request)
    {
        $this->check_permission($request, $id);
        $user = User::findOrFail($id);
        return ApiResponse::success($user);
	}

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @param Request $request
     * @return Response
     */
	public function update($id, Request $request)
	{
        $v = Validator::make($request->all(), $this->getRules($request));
        if ($v->fails()) { abort(403, $v->messages());}

        $this->check_permission($request, $id);

        $user = User::findOrFail($id);
        $input = $request->all();
        $user->fill($input);

        if($request->has('email')) {
            $user->email = $request->input('email');
        }
        if($request->has('password') && $request->input('password')) {
            $user->setPassword($request->input('password'));
        }
        // Do not allow existing empty passwords
        if(!$user->password || Hash::check('', $user->password)){
            throw new RuntimeException('Empty password! Please update.');
        }

        $user->save();
        return ApiResponse::success($user);
	}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @param Request $request
     * @return Response
     */
	public function destroy($id, Request $request)
	{
        $user = User::findOrFail($id);
        $user->delete();
        return ApiResponse::deleted();
	}

    public function check_permission(Request $request, $user_id){
        if (!Helpers::self_permission($request, $user_id)) {
            abort(403, "Permission Denied.");
        }
    }

    public function check_admin_permission(Request $request){
        return $request->user()->is_admin();
    }

    public function getRules(Request $request){
        $id = '';
        $email = 'required|unique:users,email';
        $password = 'min:6';
        if($request->method() == 'PUT' || $request->method() == 'PATCH'){
            $id = 'required';
            $email .= ','.$request->input('id');
        } elseif($request->method() == 'POST'){
            $password .= '|required';
        }

        return [
            'id' => $id,
            'org_id' => 'required|exists:organizations,id',
            'email' => $email,
            'password' => $password,
            'roles' => 'required|in:admin,user',
        ];
    }


}
