<?php

use App\Services\EasyBrokerService;
use Illuminate\Support\Facades\Route;

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

Route::get('/test', function () {
    $ebApi = new EasyBrokerService();

    $properties = $ebApi->getProperties(1, 15, [
        'statuses' => 'published'
    ]);

    return response()->json($properties);
});
