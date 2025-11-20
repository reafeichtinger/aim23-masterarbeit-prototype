<?php

namespace App\Actions\TestRun;

use App\DTOs\TestRunData;
use App\Models\TestRun;
use Illuminate\Support\Facades\Session;

class SaveTestRunAction
{
    public static function handle(TestRunData $data, ?TestRun $testRun = null): TestRun
    {
        if (!$testRun) {
            $testRun = new TestRun;
        }

        $testRun->initial_editor = $data->initial_editor;
        $testRun->started_at = $data->started_at;
        $testRun->completed_at = $data->completed_at;
        $testRun->save();

        Session::put('test-run', $testRun->hash);
        Session::save();

        return $testRun;
    }
}
