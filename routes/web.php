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

Route::get('/', 'RootController@index')->name('root.index');

Route::get('/sitemap.xml', 'SiteMapController@index')->name('root.sitemap');

Route::get('/robots.txt', function ()
{
    if (App::environment() == 'production') {
        Robots::addUserAgent('*');
        Robots::addSitemap('sitemap.xml');
    } else {
        Robots::addDisallow('*');
    }
    return Response::make(Robots::generate(), 200, ['Content-Type' => 'text/plain']);
});
