<?php namespace App\Http\Controllers;

use App\Organization;
use App\Http\ApiResponse;
use App\Http\Helpers;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class OrganizationsController extends Controller {

    /**
     * Instantiate a new OrganizationController instance.
     */
    public function __construct()
    {
        $this->middleware('admin', ['only' => ['store', 'destroy']]);
        $this->middleware('auth', ['only' => ['store', 'update', 'destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $organizations = Organization::where('1', '1');
        if(Auth::check()){
            if (!$request->user()->has_role('admin')) {
                $this->require_user($request);
            }
        }

        if ($request->has('user_id')){
            $organizations = $organizations->whereHas('user', function ($query) use ($request) {
                $query->where('id', $request->input('user_id'));
            });
        }

        if($request->has('q')){
            $needle = $request->input('q');
            $organizations = $organizations->where('organization', 'like', $needle.'%');
        }

        if($request->has('order_by')){
            $this->order_by = $request->input('order_by');
            if($request->has('sort')) {
                $this->sort = $request->input('sort');
            }
        }

        $organizations = $organizations->orderBy($this->order_by, $this->sort)->paginate(
            ($request->has('entries_count') && intval($request->input('entries_count')) > 0)?$request->input('entries_count'):$this->default_entries
        );

        return ApiResponse::success($organizations);
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

        $organization = new Organization();
        $input = $request->except(['profile_picture', 'slug']);
        $organization->$name = $request->input('name');
        $slug = Str::slug($name).'-'.$organization->id;
        $organization->slug = $slug;
        $organization->fill($input);
        $organization->save();

        if($request->has('profile_picture')) {
            $this->updatePicture($organization, $request->input('profile_picture'));
        }

        return ApiResponse::created($organization);
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
        $organization = Organization::where('1', '1');

        if ($request->has('user_id')){
            $organization = $organization->whereHas('user', function ($query) use ($request) {
                $query->where('id', $request->input('user_id'));
            });
        }
        $organization = $organization->findOrFail($id);
        return ApiResponse::success($organization);
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

        $organization = Organization::where('1','1');
        if (!$request->user()->has_role('admin')) {
            $this->require_user($request);
            $organization = $organization->whereHas('user', function ($query) use ($request) {
                $query->where('id', $request->input('user_id'));
            });
        }

        $organization = $organization->findOrFail($id);
        $input = $request->only(Schema::getColumnListing('organizations'));
        $organization->fill($input);
        if($request->has('name') && $organization->name != $request->input('name') && $request->user()->is_admin()){
            $slug = Str::slug($request->input('name'));
            $organization->slug = $slug;
            $organization->name = $request->input('name');
        }
        $organization->save();

        if($request->has('profile_picture')) {
            $this->updatePicture($organization, $request->input('profile_picture'));
        }

        return ApiResponse::success($organization);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Organization $organization
     * @param string $picture_data
     * @return bool
     */
    public function updatePicture($organization, $picture_data)
    {
        list($result, $profile_picture) = Helpers::get_image_from_base64($picture_data);
        if(!$result) {
            return false;
        }

        $filename = '/img/profiles/' . $organization->id . '_profile.jpg';
        imagejpeg($profile_picture, public_path().$filename);
        $organization->profile_picture = $filename;
        $organization->save();
        return true;
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
        $organization = Organization::findOrFail($id);
        $organization->delete();

        return ApiResponse::deleted();
    }

    public function check_permission(Request $request, $user_id){
        if (!Helpers::self_permission($request, $user_id)) {
            abort(403, "Permission denied.");
        }
    }

    public function require_user(Request $request){
        if (!$request->has('user_id')) {
            abort(403, 'Please provide User ID.');
        }
        $this->check_permission($request, $request->input('user_id'));
    }

    public function getRules(Request $request){
        $id = '';
        if($request->method() == 'PUT'){
            $id = 'required';
        }

        return [
            'id' => $id,
            'name' => 'required|min:5',
            'email' => 'email',
            'address' => 'required',
            'phone' => 'required|digits:10'
        ];
    }

}
