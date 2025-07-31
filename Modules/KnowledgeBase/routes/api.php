<?php

use Modules\Auto\Models\Brand;
use Modules\Auto\Models\ModelAuto;
use Modules\Auto\Models\Modification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/brands', function (Request $request) {
    return Brand::query()->get();
});

Route::get('/models', function (Request $request) {
    return ModelAuto::where('brand_id', $request->brand_id)->get();
});

Route::get('/modifications', function (Request $request) {
    return Modification::where('model_id', $request->model_id)->get();
});
