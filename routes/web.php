<?php

use Illuminate\Support\Facades\Route;

Route::view('/{any}', 'homepage')->where('any', '.*');
