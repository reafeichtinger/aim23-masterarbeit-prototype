<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Vinkla\Hashids\Facades\Hashids;

/**
 * Add the hashed id as an attribute to a Model.
 */
trait HasHashAttribute
{
    protected function hash(): Attribute
    {
        return Attribute::make(
            get: fn () => Hashids::encode($this->id)
        );
    }
}
