<?php

namespace App\Livewire;

use App\Actions\TestRun\DeleteTestRunAction;
use App\Enums\EditorEnum;
use App\Models\Task;
use App\Models\TestRun;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Vinkla\Hashids\Facades\Hashids;

class DoTestRun extends Component
{
    #[Locked]
    public ?int $testRunId = null;

    #[Locked]
    public ?int $editor = null;

    #[Locked]
    public ?int $step = null;

    public null|string|array $content = null;

    #region Livewire

    public function mount(string $testRun, int $editor, int $step): void
    {
        $this->testRunId = Hashids::decode($testRun)[0] ?? 0;
        $this->editor = $editor;
        $this->step = $step;

        // Abort if not a valid editor or step number
        if ($this->editor > 2 || $this->step > 5) {
            abort(404);
        }

        $this->content = $this->currentTask->content;
    }

    #endregion Livewire
    #region Properties

    #[Computed]
    public function testRun(): ?TestRun
    {
        return TestRun::where('id', $this->testRunId)->with('tasks')->first() ?? abort(404);
    }

    #[Computed]
    public function currentTask(): ?Task
    {
        $editor = (match (true) {
            $this->testRun->initial_editor == EditorEnum::CKEDITOR && $this->editor == 1 => EditorEnum::CKEDITOR,
            $this->testRun->initial_editor == EditorEnum::CKEDITOR && $this->editor == 2 => EditorEnum::GRAPESJS,
            $this->testRun->initial_editor == EditorEnum::GRAPESJS && $this->editor == 1 => EditorEnum::GRAPESJS,
            $this->testRun->initial_editor == EditorEnum::GRAPESJS && $this->editor == 2 => EditorEnum::CKEDITOR,
            default => EditorEnum::CKEDITOR,
        })->value;

        return $this->testRun->tasks->where('editor', $editor)->where('step', $this->step)->first();
    }

    #endregion Properties
    #region Actions

    public function nextStep(): void
    {
        // Navigate to the next step
        $this->redirectRoute('test-run', [
            'testRun' => $this->testRun->hash,
            'editor' => $this->editor + ($this->step == 5 ? 1 : 0),
            'step' => $this->step == 5 ? 1 : $this->step + 1,
        ], navigate: true);
    }

    public function prevStep(): void
    {
        // Navigate to the previous step
        $this->redirectRoute('test-run', [
            'testRun' => $this->testRun->hash,
            'editor' => $this->editor - ($this->step == 1 ? 1 : 0),
            'step' => $this->step == 1 ? 5 : $this->step - 1,
        ], navigate: true);
    }

    public function deleteTestRun(): void
    {
        DeleteTestRunAction::handle($this->testRun);

        $this->success('Der Testlauf wurde abgebrochen und gelöscht.', redirectTo: route('home'));
    }

    #endregion Actions
}
