<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Post\PostApiController;

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


//vue
Route::get('/',function(){
    return view('vue-index');
});
Route::get('/vue',function(){
    return view('vue-index');
});

Route::get('/vue/{any}',function(){
    return view('vue-index');
})->where('any','.*');

// Route::post('/post/download/', [PostApiController::class,'downloadPostCSV']);
