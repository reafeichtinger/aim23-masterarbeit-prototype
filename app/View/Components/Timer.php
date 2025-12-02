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
                    <span x-show="difference != 0">
                        <span x-show="hours > 0" class="countdown font-mono">
                            <span x-bind:style="'--value:' + hours + ';'" aria-live="polite" x-bind:aria-label="hours" x-text="hours"></span>
                            :
                        </span>
                        <span class="countdown font-mono -ml-1">
                            <span x-bind:style="'--value:' + minutes + '; --digits: 2;'" aria-live="polite" x-bind:aria-label="minutes" x-text="minutes"></span>
                            :
                            <span  x-bind:style="'--value:' + seconds + '; --digits: 2;'" aria-live="polite" x-bind:aria-label="seconds" x-text="seconds"></span>
                        </span>
                    </span>
                </div>
            BLADE;
    }
}
