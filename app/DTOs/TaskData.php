<?php

namespace App\DTOs;

use App\Enums\EditorEnum;
use App\Models\TestRun;
use Carbon\Carbon;

class TaskData
{
    public function __construct(
        public ?TestRun $test_run = null,
        public ?EditorEnum $editor = null,
        public ?int $step = null,
        public null|string|array $content = null,
        public ?Carbon $started_at = null,
        public ?Carbon $completed_at = null,
    ) {}
}
