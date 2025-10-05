<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ThemeStyles extends Component
{
    public function __construct()
    {
        //
    }

    public function render(): View|Closure|string
    {
        return <<<'BLADE'
                <style>
                    :root {
                        {{-- colors --}}
                        --color-primary: oklch(50.8% 0.118 165.612); {{-- emerald-700 --}}
                        --color-primary-content: oklch(97.9% 0.021 166.113); {{-- emerald-50 --}}
                        --color-secondary: oklch(84.5% 0.143 164.978); {{-- emerald-400 --}}
                        --color-secondary-content: oklch(26.2% 0.051 172.552); {{-- emerald-950 --}}
                        --color-accent: oklch(45.7% 0.24 277.023); {{-- indigo-700 --}}
                        --color-accent-content: oklch(96.2% 0.018 272.314); {{-- indigo-50 --}}
                        --color-neutral: oklch(92.8% 0.006 264.531); {{-- gray-200 --}}
                        --color-neutral-content: oklch(13% 0.028 261.692); {{-- gray-950 --}}
                        --color-base-100: oklch(1 0 255); {{-- White --}}
                        --color-base-200: oklch(98.4% 0.003 247.858); {{-- slate-50 --}}
                        --color-base-300: oklch(92.9% 0.013 255.508); {{-- slate-200 --}}
                        --color-base-content: oklch(12.9% 0.042 264.695); {{-- slate-950 --}}
                        --color-info: oklch(54.6% 0.245 262.881); {{-- blue-600 --}}
                        --color-info-content:  oklch(97% 0.014 254.604); {{-- blue-50 --}}
                        --color-success: oklch(62.7% 0.194 149.214); {{-- green-600 --}}
                        --color-success-content: oklch(98.2% 0.018 155.826); {{-- green-50 --}}
                        --color-warning: oklch(68.1% 0.162 75.834); {{-- yellow-600 --}}
                        --color-warning-content: oklch(98.7% 0.026 102.212); {{-- yellow-50 --}}
                        --color-error: oklch(57.7% 0.245 27.325); {{-- red-600 --}}
                        --color-error-content: oklch(97.1% 0.013 17.38); {{-- red-600 --}}
                        {{-- livewire --}}
                        --livewire-progress-bar-color: oklch(97% 0.014 254.604) !important; {{-- blue-50 --}}
                        {{-- fonts --}}
                        --font: 'Lexend Deca Variable', ui-sans-serif, system-ui, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
                        --font-sans: 'Lexend Deca Variable', ui-sans-serif, system-ui, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
                        --font-title: 'Lexend Deca Variable', ui-sans-serif, system-ui, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
                        font-family: var(--font);
                        {{-- border radius --}}
                        --radius-box: 0.75rem;
                        --radius-field: 0.5rem;
                        --radius-selector: 2rem;
                        {{-- base sizes --}}
                        --size-selector: 0.25rem;
                        --size-field: 0.25rem;
                        {{-- border size --}}
                        --border: 2px;
                        {{-- effects --}}
                        --depth: 0;
                        --noise: 0;
                    }
                </style>
            BLADE;
    }
}
