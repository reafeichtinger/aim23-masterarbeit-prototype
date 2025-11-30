<?php

namespace App\Livewire;

use App\Actions\Task\SaveTaskAction;
use App\Actions\TestRun\DeleteTestRunAction;
use App\DTOs\TaskData;
use App\Enums\EditorEnum;
use App\Models\Task;
use App\Models\TestRun;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Vinkla\Hashids\Facades\Hashids;

class DoTestRun extends Component
{
    #[Locked]
    public ?int $testRunId = null;

    #[Locked]
    public null|int|string $editor = null;

    #[Locked]
    public null|int|string $step = null;

    public null|string|array $content = null;
    public bool $showDeleteConfirmation = false;

    #region Livewire

    public function mount(string $testRun, int|string $editor, int|string $step): void
    {
        $this->testRunId = Hashids::decode($testRun)[0] ?? 0;
        $this->editor = (int) $editor;
        $this->step = (int) $step;

        // Abort if not a valid editor or step number
        if ($this->editor > 2 || $this->step > 5) {
            abort(404);
        }

        // Load the editor content
        $this->content = Session::get("test-run.editor-{$this->editor}.step-{$this->step}.content",
            default: $this->currentTask?->content ?? $this->testRun->currentEditor->defaultContent()
        );
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
        $nextStep = $this->step == 5 ? 1 : $this->step + 1;

        // Update the current task with content and set it to completed
        SaveTaskAction::handle(new TaskData(
            test_run: $this->testRun,
            editor: $this->testRun->currentEditor,
            step: $this->step,
            content: $this->content,
            started_at: $this->currentTask?->started_at ?? Carbon::now(),
            completed_at: $this->currentTask?->completed_at ?? Carbon::now(),
        ), task: $this->currentTask);

        // Fetch next task if exists
        $nextTask = Task::where('test_run_id', $this->testRunId)
            ->where('editor', $nextStep !== 1 ? $this->testRun->currentEditor : $this->testRun->currentEditor->other())
            ->where('step', $nextStep)
            ->first();

        // Create or update Task for the next step/editor
        SaveTaskAction::handle(new TaskData(
            test_run: $this->testRun,
            editor: $nextStep !== 1 ? $this->testRun->currentEditor : $this->testRun->currentEditor->other(),
            step: $nextStep,
            content: $nextTask->content ?? $this->content,
            started_at: $nextTask?->started_at ?? Carbon::now(),
            completed_at: $nextTask?->completed_at ?? null,
        ), task: $nextTask ?? null);

        // Navigate to the next step
        $this->redirectRoute('test-run', [
            'testRun' => $this->testRun->hash,
            'editor' => $this->editor + ($this->step == 5 ? 1 : 0),
            'step' => $nextStep,
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
    #region Listeners

    public function updatedContent(mixed $newContent = null): void
    {
        Session::put("test-run.editor-{$this->editor}.step-{$this->step}.content", $newContent);
        Session::save();
    }

    #endregion Listeners
}
