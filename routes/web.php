<?php

use App\Actions\Properties\ListProperties;
use App\Actions\Properties\SendContactForProperty;
use App\Actions\Properties\ShowProperty;
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

Route::get('/propiedades', ListProperties::class)->name('properties.list');
Route::get('/propiedades/{propertyId}', ShowProperty::class)->name('properties.show');
Route::post('/propiedades/{propertyId}/contacto', SendContactForProperty::class)->name('properties.contact');
