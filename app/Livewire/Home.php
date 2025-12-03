<?php

namespace App\Livewire;

use App\Actions\Task\SaveTaskAction;
use App\Actions\TestRun\SaveTestRunAction;
use App\DTOs\TaskData;
use App\DTOs\TestRunData;
use App\Enums\EditorEnum;
use App\Models\TestRun;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Vinkla\Hashids\Facades\Hashids;

class Home extends Component
{
    #[Url]
    public bool $completed = false;

    #[Url()]
    public ?string $hash = null;

    #region Properties

    #[Computed]
    public function testRun(): ?TestRun
    {
        return TestRun::where('id', Hashids::decode($this->hash ?? '')[0] ?? 0)->first();
    }

    #endregion Properties
    #region Actions

    public function start(): mixed
    {
        if ($testRun = TestRun::where('id', Hashids::decode(Session::get('test-run.hash') ?? '')[0] ?? 0)->with('tasks')->first()) {
            $currentEditor = $testRun?->getNumberFromEditor($testRun->currentEditor);
            $currentStep = $testRun?->currentStep;
            $this->redirectRoute('test-run', ['testRun' => $testRun->hash, 'editor' => $currentEditor, 'step' => $currentStep], navigate: true);

            return null;
        }

        $testRun = SaveTestRunAction::handle(new TestRunData(
            initial_editor: EditorEnum::casesC()->random(),
            started_at: Carbon::now(),
            completed_at: null,
        ));

        SaveTaskAction::handle(new TaskData(
            test_run: $testRun,
            editor: $testRun->initial_editor,
            step: 1,
            content: null,
            started_at: Carbon::now(),
            completed_at: null,
        ));

        return $this->success('Der Testlauf wurde gestartet.', redirectTo: route('test-run', ['testRun' => $testRun->hash, 'editor' => 1, 'step' => 1]));
    }

    public function resetTestRun(): void
    {
        Session::remove('test-run');
        $this->redirect(route('home'), navigate: true);
    }

    #endregion Actions
}
