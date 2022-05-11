<?php
use App\Http\Controllers\API\ProjectionsControler;
use App\Http\Controllers\API\MoviesControler;
use App\Http\Controllers\API\TeatroControler;
use App\Http\Controllers\API\MoviesTodayControler;
use App\Http\Controllers\API\CineAvenidaController;
use App\Http\Controllers\API\Movie\idControler;
use App\Http\Controllers\API\Movie\id2Controler;
use App\Http\Controllers\API\Movie\id3Controler;
use App\Http\Controllers\MailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Movie;
use App\Http\Controllers\API\MoviesNotToday;
use App\Http\Controllers\API\SlidesController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});




Route::get('projections', [ProjectionsControler::class, 'index']);

Route::get('avenida', [MoviesControler::class, 'index']);
Route::get('cineortega', [MoviesControler::class, 'index2']);
Route::get('teatroortega', [MoviesControler::class, 'index3']);

Route::get('moviestoday', [MoviesTodayControler::class, 'index']);

Route::get('moviesnottoday', [MoviesNotToday::class, 'index']);

Route::get('teatro', [TeatroControler::class, 'index']);

Route::get('slide', [SlidesController::class, 'index']);



//Route::get('movie/{id}', [idControler::class, 'index']);

//Route::get('movie/{id}', function($id) {
   // return Movie::find($id);
//});
Route::post('/send', [MailController::class, 'send']);

Route::get('movie/{id}', [idControler::class, 'show']);

Route::get('teatro/{id}', [id3Controler::class, 'show']);

Route::get('movie/next/{id}', [id2Controler::class, 'show']);