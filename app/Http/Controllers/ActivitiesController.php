<?php namespace App\Http\Controllers;

use App\Activity;
use App\Http\ApiResponse;
use App\Http\Helpers;
use App\Http\Requests;
use App\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use RuntimeException;


class ActivitiesController extends Controller {

    /**
     * Instantiate a new ActivityController instance.
     */
    public function __construct()
    {
        $this->middleware('admin', ['only' => ['destroy']]);
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
        $activities = Activity::where('1','1');

        if ($request->has('user_id')){
            $activities = $activities->whereHas('organization', function ($query) use ($request) {
                $query->whereHas('user', function ($query) use ($request) {
                    $query->where('id', $request->input('user_id'));
                });
            });
        }

        if ($request->has('org_id')){
            $activities = $activities->where('org_id', $request->input('org_id'));
        }

        if($request->has('q')){
            $needle = $request->input('q');
            $activities = $activities->where('activity', 'like', $needle.'%');
        }

        if($request->has('order_by')){
            $this->order_by = $request->input('order_by');
            if($request->has('sort')) {
                $this->sort = $request->input('sort');
            }
        }

        $activities = $activities->orderBy($this->order_by, $this->sort)->paginate(
            ($request->has('entries_count') && intval($request->input('entries_count')) > 0)?$request->input('entries_count'):$this->default_entries
        );

        return ApiResponse::success($activities);
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

        $activity = new Activity();
        $input = $request->only(Schema::getColumnListing('activities'));
        $activity->fill($input);

        if (!$request->user()->has_role('admin')) {
            $this->require_user($request);
            $organization = Organization::whereHas('user', function ($query) use ($request) {
                $query->where('id', $request->input('user_id'));
            })->findOrFail($request->input('org_id'));
            $activity->org_id = $organization->id;
        } else {
            $activity->org_id = $request->input('org_id');
        }
        $activity->save();

        return ApiResponse::created($activity);
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
        $activity = Activity::where('1', '1');
        if ($request->has('user_id')){
            $activity = $activity->whereHas('organization', function ($query) use ($request) {
                $query->whereHas('user', function ($query) use ($request) {
                    $query->where('id', $request->input('user_id'));
                });
            });
        }

        if ($request->has('org_id')){
            $activity = $activity->where('org_id', $request->input('org_id'));
        }

        $activity = $activity->findOrFail($id);
        return ApiResponse::success($activity);
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

        $activity = Activity::findOrFail($id);
        $input = $request->only(Schema::getColumnListing('activities'));
        $activity->fill($input);
        if (!$request->user()->has_role('admin')) {
            $this->require_user($request);
            $organization = Organization::whereHas('user', function ($query) use ($request) {
                $query->where('id', $request->input('user_id'));
            })->findOrFail($request->input('org_id'));
            $activity->org_id = $organization->id;
        } else {
            $activity->org_id = $request->input('org_id');
        }
        $activity->save();

        return ApiResponse::success($activity);
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
        $activity = Activity::findOrFail($id);

        if (!$request->user()->has_role('admin')) {
            $this->require_user($request);
            Organization::whereHas('user', function ($query) use ($request) {
                $query->where('id', $request->input('user_id'));
            })->whereHas('activities', function ($query) use ($request, $activity) {
                    $query->where('id', $activity->id);
            })->findOrFail($request->input('org_id'));
        } else {
            $activity->org_id = $request->input('org_id');
        }

        $activity->delete();

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
            'org_id' => 'required|exists:organizations,id',
            'name' => 'required|min:5',
        ];
    }

}
