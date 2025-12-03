<?php

namespace App\Models;

use App\Enums\EditorEnum;
use App\Traits\HasHashAttribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Survey extends Model
{
    use HasHashAttribute;

    protected $casts = [
        'editor' => EditorEnum::class,
        'answers' => 'array',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function testRun(): BelongsTo
    {
        return $this->belongsTo(TestRun::class);
    }
}
