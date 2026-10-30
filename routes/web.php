<?php

use App\Http\Controllers\ImageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('frontend.pages.home');
})->name('home');

Route::view('/compress-image', 'frontend.pages.compressor')->name('image.compressor');
Route::view('/crop-image', 'frontend.pages.crop')->name('image.crop');
Route::view('/convert-image', 'frontend.pages.converter')->name('image.converter');
Route::view('/remove-background', 'frontend.pages.background-remover')->name('image.background-remover');

Route::post('/upload', [ImageController::class, 'upload'])
    ->name('image.upload');

Route::get('/download/{file}', [ImageController::class, 'download'])
    ->name('image.download');
