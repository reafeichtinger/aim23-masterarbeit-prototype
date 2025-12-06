<?php

namespace App\DTOs;

use App\Enums\EditorEnum;
use App\Models\TestRun;

class OdiffResultData
{
    public function __construct(
        public ?TestRun $test_run = null,
        public ?EditorEnum $editor = null,
        public ?int $pixels = null,
        public ?float $percent = null,
        public ?array $lines = null,
    ) {}
}
