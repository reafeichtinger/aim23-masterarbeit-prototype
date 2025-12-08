<?php

namespace App\Models;

use App\Enums\EditorEnum;
use App\Traits\HasHashAttribute;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OdiffResult extends Model
{
    use HasHashAttribute;

    protected $casts = [
        'editor' => EditorEnum::class,
        'pixels' => 'integer',
        'percent' => 'float',
        'lines' => 'integer',
    ];

    public function testRun(): BelongsTo
    {
        return $this->belongsTo(TestRun::class);
    }

    #region Attributes

    public function hasDiff(): Attribute
    {
        return Attribute::make(get: function (): bool {
            return $this->pixels !== 0;
        });
    }

    public function img(string $type = '_diff'): string
    {
        return asset("storage/results/{$this->testRun->hash}/{$this->editor->value}{$type}.png");
    }

    #endregion Attributes
}
