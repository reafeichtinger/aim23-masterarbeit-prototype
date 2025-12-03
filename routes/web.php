<?php

use App\Livewire\DoTestRun;
use App\Livewire\DoTestRunSurvey;
use App\Livewire\Home;
use App\Livewire\IndexResults;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class)->name('home');
Route::get('/auswertung', IndexResults::class)->name('results');
// Editors
Route::get('/{testRun}/{editor}/befragung', DoTestRunSurvey::class)->name('test-run.survey');
Route::get('/{testRun}/{editor}/{step}', DoTestRun::class)->name('test-run');
