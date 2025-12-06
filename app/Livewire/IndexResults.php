<?php

namespace App\Livewire;

use App\Actions\TestRun\DeleteTestRunAction;
use App\Models\TestRun;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Vinkla\Hashids\Facades\Hashids;

class IndexResults extends Component
{
    #[Locked]
    public bool $unlocked = false;

    public ?string $password = null;
    public ?string $deleteHash = null;
    public bool $showDeleteConfirmation = false;

    #region Livewire

    public function mount(): void
    {
        $this->unlocked = config('app.admin-password') ? Session::get('index-results.unlocked', false) : true;
    }

    #endregion Livewire
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

    public function lock(): void
    {
        $this->unlocked = false;
        $this->password = null;
        Session::put('index-results.unlocked', false);
        Session::save();
    }

    public function unlock(): void
    {
        // Prevent password spam
        if (Session::get('index-results.password-tries', 0) > 4) {
            $this->error('Du hast zu oft das falsche Passwort eingegeben.');

            return;
        }

        // Unlock if password matches
        if ($this->password === config('app.admin-password')) {
            $this->unlocked = true;
            $this->password = null;

            Session::put('index-results.unlocked', true);
            Session::save();

            return;
        }

        // Notify and track wrong password tries
        $this->warning('Das angegebene Passwort is inkorrekt.');
        Session::increment('index-results.password-tries', 1);
    }

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

    public function deselectTestRun(): void
    {
        Session::remove('test-run');
        $this->success('Der Testlauf wurde abgewählt.');
        $this->redirectReload();
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
