<?php

use Illuminate\Support\Facades\Route;
use Modules\Auto\Http\Controllers\AutoController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('autos', AutoController::class)->names('auto');
});
