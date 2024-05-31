<?php

use App\Http\Controllers\WeatherController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

#Weather
Route::get('/weather-forecast/{city}', [WeatherController::class, 'getWeatherForecast']);
Route::get('/loadmore', [WeatherController::class, 'loadMore']);
