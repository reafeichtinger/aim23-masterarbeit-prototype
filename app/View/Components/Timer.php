<?php

namespace App\View\Components;

use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Timer extends Component
{
    public function __construct(
        public ?Carbon $timestamp = null,
    ) {
        $timestamp ??= Carbon::now();
    }

    public function render(): View|Closure|string
    {
        return <<<'BLADE'
                <div x-data="countdown({{ json_encode($timestamp) }})" {{ $attributes->class([]) }} x-cloak>
                    <div x-show="difference != 0">
                        <span x-text="minutes">00</span>:<span x-text="seconds">00</span>
                    </div>
                </div>
            BLADE;
    }
}
