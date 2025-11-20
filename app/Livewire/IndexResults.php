<?php

namespace App\Livewire;

use App\Models\TestRun;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

class IndexResults extends Component
{
    #[Computed]
    public function testRunHeaders(): array
    {
        return [
            ['key' => 'hash', 'label' => 'ID'],
            ['key' => 'initial_editor', 'label' => 'Start Editor'],
            ['key' => 'started_at', 'label' => 'Startzeitpunkt'],
            ['key' => 'completed_at', 'label' => 'Endzeitpunkt'],
        ];
    }

    #[Computed]
    public function testRuns(): Collection
    {
        return TestRun::get();
    }
}
