<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\WeatherController;



Route::get('/weather', [WeatherController::class, 'getForecast']);
