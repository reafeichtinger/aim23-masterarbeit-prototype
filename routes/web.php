<?php

use App\Livewire\Home;
use App\Livewire\Tasks\TaskOne;
use App\Livewire\Tasks\TaskTwo;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class)->name('home');
Route::get('/aufgabe-1', TaskOne::class)->name('task-1');
Route::get('/aufgabe-2', TaskTwo::class)->name('task-2');
