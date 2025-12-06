<?php

namespace App\Actions\TestRun;

use App\Models\TestRun;
use Illuminate\Support\Facades\Session;

class DeleteTestRunAction
{
    public static function handle(?TestRun $testRun = null): ?bool
    {
        $testRun?->tasks()?->delete();
        $testRun?->odiffResults()?->delete();

        Session::forget('test-run');

        return $testRun?->delete() ?? null;
    }
}
