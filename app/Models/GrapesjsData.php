<?php

namespace App\Models;

use App\Traits\HasHashAttribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GrapesjsData extends Model
{
    use HasHashAttribute;

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }
}
