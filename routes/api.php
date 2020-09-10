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


// Route::resource('/admin/user', 'API\UserController');
Route::group(['prefix' => 'admin'], function () {
    Route::resource('/user', 'API\UserController');
    Route::resource('/category', 'API\CategoryController');
    Route::resource('/post', 'API\PostController');
    Route::get('findCategory/{id}', 'API\CategoryController@findCategory');
    Route::get('/profile', 'API\UserController@profile');
    Route::get('/findUsers', 'API\UserController@findUsers');
    Route::put('/profile', 'API\UserController@updateProfile');

});

Route::post('frontend/contact', 'API\FrontendController@postContact');
Route::get('frontend/latest-news', 'API\FrontendController@getLatestNews');
Route::get('frontend/feature-hot', 'API\FrontendController@getFeatureHot');
Route::get('frontend/detail/{slug}', 'API\FrontendController@getPostDetail');
Route::get('frontend/list-categories', 'API\FrontendController@getListCategories');
Route::get('frontend/list-posts-by-category/{id}', 'API\FrontendController@getListPostsByCategory');
Route::put('frontend/add-view/{id}', 'API\FrontendController@addView');
Route::get('frontend/hot-news', 'API\FrontendController@getHotNews');
Route::get('frontend/feature-news', 'API\FrontendController@getFeatureNews');
Route::get('frontend/posts_by_category/{slug}', 'API\FrontendController@getPostsByCategory');
Route::get('frontend/top-views', 'API\FrontendController@getTopViews');
Route::get('frontend/related-posts/{id}', 'API\FrontendController@getRelatedPosts');
