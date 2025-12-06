<?php

namespace App\DTOs;

use App\Models\Task;

class GrapesjsDataData
{
    public function __construct(
        public ?Task $task = null,
        public ?string $html = null,
        public ?string $css = null,
    ) {}
}
