<?php

use Illuminate\Support\Facades\Route;
use Laravel\Passport\Passport;



Route::group([
    'middleware' => 'web',
], function () {
    Passport::routes();
});
