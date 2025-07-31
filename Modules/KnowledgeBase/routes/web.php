<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\KnowledgeController;

Route::get('/', [KnowledgeController::class, 'index'])->name('knowledge.index');
