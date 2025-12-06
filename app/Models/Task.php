<?php

namespace App\Models;

use App\Enums\EditorEnum;
use App\Traits\HasHashAttribute;
use App\Utils\DocumentVariables;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Task extends Model
{
    use HasHashAttribute;

    protected $casts = [
        'editor' => EditorEnum::class,
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function testRun(): BelongsTo
    {
        return $this->belongsTo(TestRun::class);
    }

    public function grapesjsData(): HasOne
    {
        return $this->hasOne(GrapesjsData::class);
    }

    #region Attributes

    public function html(): Attribute
    {
        return Attribute::make(get: function (): string {
            return match ($this->editor) {
                EditorEnum::GRAPESJS => $this->grapesjsData?->html ?? '',
                EditorEnum::CKEDITOR => $this->content ?? '',
                default => $this->content ?? '',
            };
        });
    }

    public function css(): Attribute
    {
        return Attribute::make(get: function (): string {
            return match ($this->editor) {
                EditorEnum::GRAPESJS => $this->grapesjsData?->css ?? '',
                EditorEnum::CKEDITOR => file_get_contents(resource_path('css/ckeditor-pdf.css')),
                default => file_get_contents(resource_path('css/ckeditor-pdf.css')),
            };
        });
    }

    public function variables(): Attribute
    {
        return Attribute::make(get: function (): array {
            return match ($this->editor) {
                EditorEnum::GRAPESJS => [],
                EditorEnum::CKEDITOR => DocumentVariables::forCKEditorPrint(),
                default => DocumentVariables::forCKEditorPrint(),
            };
        });
    }

    #region Attributes

}
