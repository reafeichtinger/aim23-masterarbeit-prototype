<?php

namespace App\Actions\Survey;

use App\DTOs\SurveyData;
use App\Models\Survey;

class SaveSurveyAction
{
    public static function handle(SurveyData $data, ?Survey $task = null): Survey
    {
        if (!$task) {
            $task = new Survey;
        }

        $task->testRun()->associate($data->test_run);
        $task->editor = $data->editor;
        $task->answers = $data->answers;
        $task->started_at = $data->started_at;
        $task->completed_at = $data->completed_at;
        $task->save();

        return $task;
    }
}
