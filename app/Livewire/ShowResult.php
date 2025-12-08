<?php

namespace App\Livewire;

use App\Actions\OdiffResult\GenerateOdiffResultsAction;
use App\Enums\EditorEnum;
use App\Models\OdiffResult;
use App\Models\TestRun;
use App\Utils\Pdf;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Vinkla\Hashids\Facades\Hashids;

class ShowResult extends Component
{
    #[Locked]
    public ?int $testRunId = null;

    #[Url(as: 't', except: true)]
    public bool $showTasks = true;

    #[Url(as: 's', except: true)]
    public bool $showSurveys = true;

    #[Url(as: 'r', except: true)]
    public bool $showResults = true;

    #[Url(as: 'd', except: '_diff')]
    public string $odiffType = '_diff';

    public bool $showOdiff = false;
    public string $odiffEditor = 'ckeditor';
    public array $expandedSurveys = [];

    #region Livewire

    public function mount(string $testRun): void
    {
        if (config('app.admin-password') && Session::get('index-results.unlocked', false) === false) {
            abort(404);
        }

        $this->testRunId = Hashids::decode($testRun)[0] ?? 0;
    }

    #endregion Livewire
    #region Properties

    #[Computed]
    public function testRun(): ?TestRun
    {
        return TestRun::where('id', $this->testRunId)->with('tasks', function ($tasks) {
            $tasks->with('grapesjsData');
        })->with(['surveys', 'odiffResults'])->first() ?? abort(404);
    }

    #[Computed]
    public function taskHeaders(): array
    {
        return [
            ['key' => 'editor', 'label' => 'Editor'],
            ['key' => 'step', 'label' => 'Aufgabe'],
            ['key' => 'started_at', 'label' => 'Startzeitpunkt'],
            ['key' => 'completed_at', 'label' => 'Endzeitpunkt'],
            ['key' => 'duration', 'label' => 'Dauer'],
        ];
    }

    #[Computed]
    public function surveyHeaders(): array
    {
        return [
            ['key' => 'editor', 'label' => 'Editor'],
            ['key' => 'started_at', 'label' => 'Startzeitpunkt'],
            ['key' => 'completed_at', 'label' => 'Endzeitpunkt'],
            ['key' => 'duration', 'label' => 'Dauer'],
        ];
    }

    #[Computed]
    public function currentDiff(): ?OdiffResult
    {
        return $this->testRun->odiffResults->where('editor', $this->odiffEditor)->first();
    }

    #endregion Properties
    #region Actions

    public function generateResults(): void
    {
        /** @var Storage $storage */
        $storage = Storage::disk('public');
        $storage->deleteDirectory("results/{$this->testRun->hash}");

        // Start generating pdfs
        $files = Pdf::generateResultPdfs($this->testRun);
        $basePath = Str::beforeLast($files[0], '/');

        // Check if pdfs were generated successfully
        if (count($files) != 2) {
            $this->error('Fehler beim Generieren der .pdf Dateien.');

            return;
        }

        // Convert pdfs to pngs
        foreach (EditorEnum::values() as $editor) {
            $input = "$basePath/$editor.pdf";
            $output = str_replace('.pdf', '.png', $input);
            Artisan::call("app:pdf-to-png \"$input\" \"$output\"");
        }

        // Check if pngs were generated successfully
        if (!$storage->exists("results/{$this->testRun->hash}/ckeditor.png") || !$storage->exists("results/{$this->testRun->hash}/grapesjs.png")) {
            $this->error('Fehler beim Generieren der .png Dateien.');

            return;
        }

        // Create odiff results
        GenerateOdiffResultsAction::handle($basePath, $this->testRun);

        // Generated results should now be available
        unset($this->testRun);
        if (!$this->hasGeneratedResults()) {
            $this->error('Fehler beim Generieren der _diff.png Dateien.');

            return;
        }
    }

    public function prevOdiff(): void
    {
        $this->odiffType = match ($this->odiffType) {
            '_diff' => '_diff_switch_no_mask_no_aa',
            '_diff_no_aa' => '_diff',
            '_diff_no_mask' => '_diff_no_aa',
            '_diff_no_mask_no_aa' => '_diff_no_mask',
            '_diff_switch_no_mask' => '_diff_no_mask_no_aa',
            '_diff_switch_no_mask_no_aa' => '_diff_switch_no_mask',
        };
    }

    public function nextOdiff(): void
    {
        $this->odiffType = match ($this->odiffType) {
            '_diff' => '_diff_no_aa',
            '_diff_no_aa' => '_diff_no_mask',
            '_diff_no_mask' => '_diff_no_mask_no_aa',
            '_diff_no_mask_no_aa' => '_diff_switch_no_mask',
            '_diff_switch_no_mask' => '_diff_switch_no_mask_no_aa',
            '_diff_switch_no_mask_no_aa' => '_diff',
        };
    }

    #endregion Actions
    #region Listeners

    #[On('toggle-odiff-modal')]
    public function toggledOdiffModal(?bool $show = false, ?string $editor = null): void
    {
        $this->showOdiff = $show ?? false;
        $this->odiffEditor = $editor ? EditorEnum::parse($editor)->value : EditorEnum::CKEDITOR->value;
    }

    #endregion Listeners
    #region Helpers

    public function hasGeneratedResults(): bool
    {
        return $this->testRun->odiffResults->count() === 2;
    }

    #endregion Helpers
}
