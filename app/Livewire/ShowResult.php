<?php

namespace App\Livewire;

use App\Models\TestRun;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Vinkla\Hashids\Facades\Hashids;

class ShowResult extends Component
{
    #[Locked]
    public ?int $testRunId = null;

    #region Livewire

    public function mount(string $testRun): void
    {

        $this->testRunId = Hashids::decode($testRun)[0] ?? 0;
    }

    #endregion Livewire
    #region Properties

    #[Computed]
    public function testRun(): ?TestRun
    {
        return TestRun::where('id', $this->testRunId)->with(['tasks', 'surveys'])->first() ?? abort(404);
    }

    #endregion Properties
}
