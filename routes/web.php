<?php

use App\Livewire\DoTestRun;
use App\Livewire\DoTestRunSurvey;
use App\Livewire\Home;
use App\Livewire\IndexResults;
use App\Livewire\ShowResult;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class)->name('home');
Route::get('/auswertung', IndexResults::class)->name('results');
Route::get('/auswertung/{testRun}', ShowResult::class)->name('show-result');
// Editors
Route::get('/{testRun}/{editor}/befragung', DoTestRunSurvey::class)->name('test-run.survey');
Route::get('/{testRun}/{editor}/{step}', DoTestRun::class)->name('test-run');
