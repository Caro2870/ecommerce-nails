<?php

use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/galeria', [GalleryController::class, 'index'])->name('gallery');
Route::get('/api/portfolio', [GalleryController::class, 'api'])->name('gallery.api');
