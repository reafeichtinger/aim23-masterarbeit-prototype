<?php

namespace App\Livewire;

use App\Actions\TestRun\DeleteTestRunAction;
use App\Models\TestRun;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Vinkla\Hashids\Facades\Hashids;

class IndexResults extends Component
{
    public ?string $deleteHash = null;
    public bool $showDeleteConfirmation = false;

    #region Properties

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
        return TestRun::with('tasks')->get();
    }

    #endregion Properties
    #region Actions

    public function continueTestRun(string $hash): void
    {
        if (!($testRun = $this->testRuns->where('id', Hashids::decode($hash)[0] ?? 0)->first())) {
            $this->error('Kein Testlauf gefunden');

            return;
        }

        Session::put('test-run.hash', $testRun->hash);
        Session::save();

        $this->redirect(route('test-run', [
            'testRun' => $testRun->hash,
            'editor' => $testRun->tasks->where('editor', '!=', $testRun->initial_editor)->count() ? 2 : 1,
            'step' => $testRun->currentStep,
        ]));
    }

    public function deleteTestRun(): void
    {
        if ($this->deleteHash) {
            DeleteTestRunAction::handle($this->testRuns->where('id', Hashids::decode($this->deleteHash)[0] ?? 0)->first());

            $this->success('Der Testlauf wurde gelöscht.');
            $this->redirectReload();
        }
    }

    #endregion Actions
    #region Listeners

    #[On('toggle-delete-confirmation')]
    public function onToggleDeleteConfirmation(?string $hash = null): void
    {
        $this->deleteHash = $hash;
        $this->showDeleteConfirmation = (bool) $this->deleteHash;
    }

    #endregion Listeners
}
