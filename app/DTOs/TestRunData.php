<?php

namespace App\DTOs;

use App\Enums\EditorEnum;
use Carbon\Carbon;

class TestRunData
{
    public function __construct(
        public ?EditorEnum $initial_editor = null,
        public ?Carbon $started_at = null,
        public ?Carbon $completed_at = null,
    ) {}
}
