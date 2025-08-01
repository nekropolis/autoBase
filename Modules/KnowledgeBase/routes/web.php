<?php

use Illuminate\Support\Facades\Route;
use Modules\KnowledgeBase\Http\Controllers\KnowledgeController;

Route::get('/', [KnowledgeController::class, 'index'])->name('knowledge.index');
