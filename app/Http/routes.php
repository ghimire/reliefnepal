<?php

use App\Organization;

Route::pattern('id', '[0-9]+');
Route::pattern('slug', '[a-z0-9-]+');

Route::bind('slug', function($slug)
{
    return Organization::whereSlug($slug)->firstOrFail();
});

// RESTFul APIs
Route::group(['prefix' => 'api', 'middleware' => 'auth', 'after' => 'allowOrigin'], function() {
    Route::resource('users', 'UsersController', ['except' => ['create', 'edit']]);
    Route::resource('settings', 'SettingsController', ['except' => ['create', 'edit']]);
});

Route::group(['prefix' => 'api', 'after' => 'allowOrigin'], function() {
    Route::resource('activities', 'ActivitiesController', ['except' => ['create', 'edit']]);
    Route::resource('organizations', 'OrganizationsController', ['except' => ['create', 'edit']]);
});

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

Route::get('/', 'PortalController@index');
Route::get('/home', function(){
    return redirect('/');
});

Event::listen('401', function()
{
    abort(401);
});

Event::listen('403', function()
{
    abort(403);
});

Event::listen('404', function()
{
    abort(404);
});

Event::listen('422', function()
{
    abort(403);
});

Event::listen('500', function()
{
    abort(500);
});

Event::listen('503', function()
{
    abort(503);
});


Route::filter('before', function()
{
    // Do stuff before every request to your application...
});

Route::filter('after', function($response)
{
    // Do stuff after every request to your application...
});

Route::filter('allowOrigin', function($route, $request, $response)
{
    $response->header('access-control-allow-origin', '*');
});