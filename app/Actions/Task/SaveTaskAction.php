<?php

namespace App\Actions\Task;

use App\DTOs\TaskData;
use App\Models\Task;

class SaveTaskAction
{
    public static function handle(TaskData $data, ?Task $task = null): Task
    {
        if (!$task) {
            $task = new Task;
        }

        $task->testRun()->associate($data->test_run);
        $task->editor = $data->editor;
        $task->step = $data->step;
        $task->content = $data->content;
        $task->started_at = $data->started_at;
        $task->completed_at = $data->completed_at;
        $task->save();

        return $task;
    }
}
