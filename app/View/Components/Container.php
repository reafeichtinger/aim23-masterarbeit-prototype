<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Container extends Component
{
    public function __construct(
        public bool $reverse = false,
        public bool $padding = true,
        public bool $sticky = true,

        public ?string $right = null,
    ) {}

    public function render(): View|Closure|string
    {
        return <<<'BLADE'
                <div
                    class="w-full grow flex xl:flex-row xl:space-x-6 xl:items-start {{ ($reverse ? 'flex-col' : 'flex-col-reverse') . ($padding ? ' pb-24' : '') }}">
                    <div class="h-min w-full space-y-4 sm:space-y-6 xl:space-y-8 {{ $right ?? null ? 'xl:w-2/3' : '' }}">
                        {{ $slot }}
                    </div>

                    @isset($right)
                        <div class="w-full xl:w-1/3">
                            <div
                                class="flex flex-col space-y-4 sm:space-y-6 xl:space-y-8 {{ ($reverse ? 'mt-4 sm:mt-6 xl:mt-0' : 'mb-4 sm:mb-6 xl:mb-0') . ($sticky ? ' xl:sticky xl:top-20' : '') }}">
                                {{ $right }}
                            </div>
                        </div>
                    @endisset
                </div>
            BLADE;
    }
}
