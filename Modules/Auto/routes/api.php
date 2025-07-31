<?php

use Illuminate\Support\Facades\Route;
use Modules\Auto\Http\Controllers\AutoController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('autos', AutoController::class)->names('auto');
});
