<?php

namespace App\Models;

use App\Enums\EditorEnum;
use App\Traits\HasHashAttribute;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TestRun extends Model
{
    use HasHashAttribute;

    protected $casts = [
        'initial_editor' => EditorEnum::class,
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    #region Relations

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    #endregion Relations
    #region Attributes

    public function currentEditor(): Attribute
    {
        return Attribute::make(get: function (): EditorEnum {
            $editor = $this->tasks->where('editor', '!=', $this->initial_editor)->count() ? 2 : 1;

            return $this->getEditorFromNumber($editor);
        });
    }

    public function currentStep(): Attribute
    {
        return Attribute::make(get: function (): int {
            return $this->tasks->where('editor', $this->currentEditor)->sortByDesc('step')->first()->step;
        });
    }

    #endregion Attributes
    #region Helpers

    public function getEditorFromNumber(int $number): EditorEnum
    {
        return match (true) {
            $this->initial_editor == EditorEnum::CKEDITOR && $number == 1 => EditorEnum::CKEDITOR,
            $this->initial_editor == EditorEnum::CKEDITOR && $number == 2 => EditorEnum::GRAPESJS,
            $this->initial_editor == EditorEnum::GRAPESJS && $number == 1 => EditorEnum::GRAPESJS,
            $this->initial_editor == EditorEnum::GRAPESJS && $number == 2 => EditorEnum::CKEDITOR,
            default => EditorEnum::CKEDITOR,
        };
    }

    public function getNumberFromEditor(EditorEnum $editor): int
    {
        return match (true) {
            $this->initial_editor == EditorEnum::CKEDITOR && $editor == EditorEnum::CKEDITOR => 1,
            $this->initial_editor == EditorEnum::CKEDITOR && $editor == EditorEnum::GRAPESJS => 2,
            $this->initial_editor == EditorEnum::GRAPESJS && $editor == EditorEnum::GRAPESJS => 1,
            $this->initial_editor == EditorEnum::GRAPESJS && $editor == EditorEnum::CKEDITOR => 2,
            default => 1,
        };
    }

    #endregion Helpers
}
