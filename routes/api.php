<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('register', 'APIAuthController@register');
    Route::post('login', 'APIAuthController@login');
    Route::post('logout', 'APIAuthController@logout');
    Route::post('refresh', 'APIAuthController@refresh');
 Route::group(['middleware' => 'jwt.auth'], function(){
  Route::get('user', 'APIAuthController@user');

});
});

/*
=====================
AUTHENTICATED ROUTES
=====================
*/

 Route::group(['middleware' => 'jwt.auth'], function(){
  
});

 Route::resource('questions','QuestionsController');
  Route::resource('question/categories', 'QuestionCategoriesController');
 Route::resource('tags', 'TagsController');

 /*
 ==============================
 ROLE BASED AUTHENTICATION
 ==============================

 */

 Route::resource('roles','RolesController');
  Route::resource('permissions','PermissionsController');
  Route::post('assign-role','APIAuthController@assignRole');
  Route::post('assign-permission','APIAuthController@attachPermission');
  Route::post('change-password','APIAuthController@changePassword');

  /*
 ==============================
 USERS
 ==============================

 */
Route::get('users/list','UsersController@index');
Route::get('users/profile','UsersController@userProfile');
Route::get('users/update-profile','UsersController@updateProfile');
Route::get('users/avatar','UsersController@avatar');
Route::get('users/roles','UsersController@userRoles');
Route::get('users/permissions','UsersController@userPermissions');





