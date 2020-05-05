<?php

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;
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
    return view('cat');
});


Route::get('/{number}',  function ($number) {

    for ($i = 1; $i <= 1000000; $i++) {


      $data =   App\Http\Controllers\CatController::allCats(request());
        $url = request()->url();
        $queryParams = request()->query();
        //Sorting query params by key (acts by reference)
        ksort($queryParams);
        //Transforming the query array to query string
        $queryString = http_build_query($queryParams);

        $fullUrl = "{$url}?{$queryString}";
        $expiresAt = Carbon::now()->addMinutes(1);
        return Cache::remember($fullUrl, $expiresAt, function () use ($data) {
            return $data;
        });
    }
});
//Route::get('/kot/{number}', 'CatController@allCats');