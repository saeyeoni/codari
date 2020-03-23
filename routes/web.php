<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'LoginController@login')->middleware('checking');

Route::get('/login','LoginController@login')->middleware('checking');
Route::post('/login', 'LoginController@loginCheck')->name('loginCheck');

Route::get('/main','MainController@index')->middleware('checking');
Route::get('/logout', 'MainController@destroy');
Route::get('/{menu_id}', [
  'uses' => 'MainController@setSidebar'
  ])->middleware('checking');

Route::GET('/marketing/M01/items','marketing\M01Controller@getItems')->name('items');
Route::GET('/marketing/M01/brands','marketing\M01Controller@getBrands')->name('brands');
Route::PATCH('/marketing/M02/brands/{id}','marketing\M02Controller@delBrand');
Route::GET('/marketing/M02/list','marketing\M02Controller@getList')->name('list');
Route::GET('marketing/M02/{id}','marketing\M02Controller@show' );
Route::DELETE('marketing/M02/{id}','marketing\M02Controller@softDelete' );
Route::PATCH('marketing/M02/{id}','marketing\M02Controller@update' );

Route::GET('overseas/O01/items','overseas\O01Controller@getItems')->name('overitems');
Route::GET('overseas/O01/brands','overseas\O01Controller@getBrands')->name('overbrands');
Route::PATCH('/overseas/O02/brands/{id}','overseas\O02Controller@delBrand');
Route::GET('overseas/O02/list','overseas\O02Controller@getList')->name('overlist');
Route::GET('overseas/O02/{id}','overseas\O02Controller@show' );
Route::DELETE('overseas/O02/{id}','overseas\O02Controller@softDelete' );
Route::PATCH('overseas/O02/{id}','overseas\O02Controller@update' );

Route::prefix('{menu_id}')->middleware('checking')->group(function (){
    Route::GET('{pgm_id}', 'SidebarController@index');
    Route::GET('{pgm_id}/create', 'SidebarController@create');
    Route::POST('{pgm_id}', 'SidebarController@store');
    Route::PATCH('{pgm_id}', 'SidebarController@update');
    Route::GET('{pgm_id}/{id}','SidebarController@show' );
    Route::DELETE('{pgm_id}/{id}', 'SidebarController@delete');
  });
