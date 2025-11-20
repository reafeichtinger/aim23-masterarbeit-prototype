<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Logo extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return <<<'BLADE'
                <a href="/" wire:navigate>
                    {{-- Hidden when collapsed --}}
                    <div {{ $attributes->class(["hidden-when-collapsed p-2.5 md:p-5.5"]) }}>
                        <div class="flex items-center gap-2 w-fit">
                            <span class="font-bold text-3xl me-3 bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent ">
                                {{ explode('-', config('app.name'))[0] ?? '' }}
                            </span>
                        </div>
                    </div>

                    {{-- Display when collapsed --}}
                    <div class="display-when-collapsed hidden p-2.5 md:p-5.5 mt-1 mb-1.5">
                        <x-icon name="s-pencil-square" class="w-6 text-primary" />
                    </div>
                </a>
            BLADE;
    }
}
