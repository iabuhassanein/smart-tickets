<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Frontend\MainController;

Route::get('/{any?}', [MainController::class, 'index'])->where('any', '.*');
