<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\AdminUsersController;
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

Route::get('/', function () {
    return view('welcome');
});




/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('admin-users')->name('admin-users/')->group(static function() {
            Route::get('/',                                             'App\Http\Controllers\Admin\AdminUsersController@index')->name('index');
            Route::get('/create',                                       'App\Http\Controllers\Admin\AdminUsersController@create')->name('create');
            Route::post('/',                                            'App\Http\Controllers\Admin\AdminUsersController@store')->name('store');
            Route::get('/{adminUser}/impersonal-login',                 'App\Http\Controllers\Admin\AdminUsersController@impersonalLogin')->name('impersonal-login');
            Route::get('/{adminUser}/edit',                             'App\Http\Controllers\Admin\AdminUsersController@edit')->name('edit');
            Route::post('/{adminUser}',                                 'App\Http\Controllers\Admin\AdminUsersController@update')->name('update');
            Route::delete('/{adminUser}',                               'App\Http\Controllers\Admin\AdminUsersController@destroy')->name('destroy');
            Route::get('/{adminUser}/resend-activation',                'App\Http\Controllers\Admin\AdminUsersController@resendActivationEmail')->name('resendActivationEmail');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::get('/profile',                                      'App\Http\Controllers\Admin\ProfileController@editProfile')->name('edit-profile');
        Route::post('/profile',                                     'App\Http\Controllers\Admin\ProfileController@updateProfile')->name('update-profile');
        Route::get('/password',                                     'App\Http\Controllers\Admin\ProfileController@editPassword')->name('edit-password');
        Route::post('/password',                                    'App\Http\Controllers\Admin\ProfileController@updatePassword')->name('update-password');
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('actors')->name('actors/')->group(static function() {
            Route::get('/',                                             'ActorsController@index')->name('index');
            Route::get('/create',                                       'ActorsController@create')->name('create');
            Route::post('/',                                            'ActorsController@store')->name('store');
            Route::get('/{actor}/edit',                                 'ActorsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'ActorsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{actor}',                                     'ActorsController@update')->name('update');
            Route::delete('/{actor}',                                   'ActorsController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('cinemas')->name('cinemas/')->group(static function() {
            Route::get('/',                                             'CinemasController@index')->name('index');
            Route::get('/create',                                       'CinemasController@create')->name('create');
            Route::post('/',                                            'CinemasController@store')->name('store');
            Route::get('/{cinema}/edit',                                'CinemasController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'CinemasController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{cinema}',                                    'CinemasController@update')->name('update');
            Route::delete('/{cinema}',                                  'CinemasController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('directors')->name('directors/')->group(static function() {
            Route::get('/',                                             'DirectorsController@index')->name('index');
            Route::get('/create',                                       'DirectorsController@create')->name('create');
            Route::post('/',                                            'DirectorsController@store')->name('store');
            Route::get('/{director}/edit',                              'DirectorsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'DirectorsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{director}',                                  'DirectorsController@update')->name('update');
            Route::delete('/{director}',                                'DirectorsController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('movies')->name('movies/')->group(static function() {
            Route::get('/',                                             'MoviesController@index')->name('index');
            Route::get('/create',                                       'MoviesController@create')->name('create');
            Route::post('/',                                            'MoviesController@store')->name('store');
            Route::get('/{movie}/edit',                                 'MoviesController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'MoviesController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{movie}',                                     'MoviesController@update')->name('update');
            Route::delete('/{movie}',                                   'MoviesController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('projections')->name('projections/')->group(static function() {
            Route::get('/',                                             'ProjectionsController@index')->name('index');
            Route::get('/create',                                       'ProjectionsController@create')->name('create');
            Route::post('/',                                            'ProjectionsController@store')->name('store');
            Route::get('/{projection}/edit',                            'ProjectionsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'ProjectionsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{projection}',                                'ProjectionsController@update')->name('update');
            Route::delete('/{projection}',                              'ProjectionsController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('qualifications')->name('qualifications/')->group(static function() {
            Route::get('/',                                             'QualificationsController@index')->name('index');
            Route::get('/create',                                       'QualificationsController@create')->name('create');
            Route::post('/',                                            'QualificationsController@store')->name('store');
            Route::get('/{qualification}/edit',                         'QualificationsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'QualificationsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{qualification}',                             'QualificationsController@update')->name('update');
            Route::delete('/{qualification}',                           'QualificationsController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('rooms')->name('rooms/')->group(static function() {
            Route::get('/',                                             'RoomsController@index')->name('index');
            Route::get('/create',                                       'RoomsController@create')->name('create');
            Route::post('/',                                            'RoomsController@store')->name('store');
            Route::get('/{room}/edit',                                  'RoomsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'RoomsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{room}',                                      'RoomsController@update')->name('update');
            Route::delete('/{room}',                                    'RoomsController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('slides')->name('slides/')->group(static function() {
            Route::get('/',                                             'SlidesController@index')->name('index');
            Route::get('/create',                                       'SlidesController@create')->name('create');
            Route::post('/',                                            'SlidesController@store')->name('store');
            Route::get('/{slide}/edit',                                 'SlidesController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'SlidesController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{slide}',                                     'SlidesController@update')->name('update');
            Route::delete('/{slide}',                                   'SlidesController@destroy')->name('destroy');

        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('syncronitations')->name('syncronitations/')->group(static function() {
            Route::get('/',                                             'SyncronitationsController@index')->name('index');
            Route::get('/create',                                       'SyncronitationsController@create')->name('create');
            Route::post('/',                                            'SyncronitationsController@store')->name('store');
            Route::get('/{syncronitation}/edit',                        'SyncronitationsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'SyncronitationsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{syncronitation}',                            'SyncronitationsController@update')->name('update');
            Route::delete('/{syncronitation}',                          'SyncronitationsController@destroy')->name('destroy');
        });
    });
});