<?php

namespace App\Livewire;

use App\Actions\Survey\SaveSurveyAction;
use App\Actions\TestRun\DeleteTestRunAction;
use App\Actions\TestRun\SaveTestRunAction;
use App\DTOs\SurveyData;
use App\DTOs\TestRunData;
use App\Enums\EditorEnum;
use App\Enums\SusEnum;
use App\Models\Survey;
use App\Models\Task;
use App\Models\TestRun;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Vinkla\Hashids\Facades\Hashids;

class DoTestRunSurvey extends Component
{
    #[Locked]
    public ?int $testRunId = null;

    #[Locked]
    public null|int|string $editor = null;

    public array $answers = [];

    #region Livewire

    public function mount(string $testRun, int|string $editor): void
    {
        $this->testRunId = Hashids::decode($testRun)[0] ?? 0;
        $this->editor = (int) $editor;

        // Abort if not a valid editor or step number
        if ($this->editor > 2) {
            abort(404);
        }

        // If Survery does not exist yet, create it
        if (!$this->survey) {
            // Set all question values to 0 so they must be actively changed
            foreach (SusEnum::values() as $question) {
                $this->answers[$question] = 0;
            }

            SaveSurveyAction::handle(new SurveyData(
                test_run: $this->testRun,
                editor: $this->currentEditor,
                answers: $this->answers,
                started_at: Carbon::now(),
                completed_at: null,
            ));
            unset($this->survey);
        }

        $this->answers = $this->survey?->answers ?? [];
    }

    protected function rules(): array
    {
        $rules = [
            'answers' => ['required', 'array', 'size:11'],
            'answers.question_open' => ['required', 'string', 'between:10,10000'],
        ];

        foreach (SusEnum::values() as $value) {
            $rules["answers.$value"] = ['required', 'numeric', 'integer', 'between:1,5'];
        }

        return $rules;
    }

    protected function validationAttributes(): array
    {
        return [
            'answers' => 'Fragen',
            'answers.*' => 'Der Wert dieser Frage',
        ];
    }

    #endregion Livewire
    #region Properties

    #[Computed]
    public function testRun(): ?TestRun
    {
        return TestRun::where('id', $this->testRunId)->with(['tasks', 'surveys'])->first() ?? abort(404);
    }

    #[Computed]
    public function survey(): ?Survey
    {
        return $this->testRun->surveys->where('editor', $this->currentEditor)->first();
    }

    #[Computed]
    public function currentEditor(): EditorEnum
    {
        return match (true) {
            $this->testRun->initial_editor == EditorEnum::CKEDITOR && $this->editor == 1 => EditorEnum::CKEDITOR,
            $this->testRun->initial_editor == EditorEnum::CKEDITOR && $this->editor == 2 => EditorEnum::GRAPESJS,
            $this->testRun->initial_editor == EditorEnum::GRAPESJS && $this->editor == 1 => EditorEnum::GRAPESJS,
            $this->testRun->initial_editor == EditorEnum::GRAPESJS && $this->editor == 2 => EditorEnum::CKEDITOR,
            default => EditorEnum::CKEDITOR,
        };
    }

    #[Computed]
    public function currentTask(): ?Task
    {
        return $this->testRun->tasks->where('editor', $this->currentEditor->value)->sortByDesc('step')->first();
    }

    #endregion Properties
    #region Actions

    public function nextStep(): void
    {
        if (!$this->survey) {
            $this->error('Etwas ist schiefgelaufen, bitte lade die Seite erneut und versuch es noch einmal.');

            return;
        }

        $this->validate();

        // Set answers and mark as completed
        SaveSurveyAction::handle(new SurveyData(
            test_run: $this->testRun,
            editor: $this->currentEditor,
            answers: $this->answers,
            started_at: $this->survey->started_at,
            completed_at: $this->survey->completed_at ?? Carbon::now(),
        ), $this->survey);

        // Complete the TestRun if at last editor survey
        if ($this->editor === 2) {
            $this->completeTestRun();

            return;
        }

        // Navigate to the next editor
        $this->redirectRoute('test-run', [
            'testRun' => $this->testRun->hash,
            'editor' => 2,
            'step' => 1,
        ], navigate: true);
    }

    public function prevStep(): void
    {
        // Navigate to the previous step
        $this->redirectRoute('test-run', [
            'testRun' => $this->testRun->hash,
            'editor' => $this->editor,
            'step' => 5,
        ], navigate: true);
    }

    public function completeTestRun(): void
    {
        // Set test run to completed
        SaveTestRunAction::handle(new TestRunData(
            initial_editor: $this->testRun->initial_editor,
            started_at: $this->testRun->started_at,
            completed_at: Carbon::now(),
        ), testRun: $this->testRun);

        // Remove test run from session
        Session::forget('test-run');

        // Redirect back to start
        $this->success('Der Testlauf wurde erfolgreich abgeschlossen!', redirectTo: route('home', ['completed' => true, 'hash' => $this->testRun->hash]));
    }

    public function deleteTestRun(): void
    {
        DeleteTestRunAction::handle($this->testRun);

        $this->success('Der Testlauf wurde abgebrochen und gelöscht.', redirectTo: route('home'));
    }

    #endregion Actions
}
