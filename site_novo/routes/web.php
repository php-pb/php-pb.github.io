<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\JobListingController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SpeakerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.home');
})->name('home');

Route::get('/blog', [PostController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [PostController::class, 'show'])->name('blog.show');

Route::get('/eventos', [EventController::class, 'index'])->name('events.index');

Route::get('/vagas', [JobListingController::class, 'index'])->name('jobs.index');

Route::get('/palestrantes', [SpeakerController::class, 'index'])->name('speakers.index');
