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
    $form = [
        'name' => 'test',
        'email' => 'main@example.com',
        'message' => 'AAA',
        'source' => 'https://test.com'
    ];

    $response = $ebApi->submit('/contact_requests', $form);


    return response()->json($response);
});
