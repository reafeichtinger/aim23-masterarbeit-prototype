<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Ckeditor extends Component
{
    public function __construct(
        public ?string $id = null,
        public ?string $content = null,
    ) {}

    public function render(): View|Closure|string
    {
        return <<<'BLADE'
                {{-- Editor JS instance --}}
                <livewire:ckeditor5
                    editorId="{{ $id ?? 'decoupled-editor' }}"
                    editorType="decoupled"
                    :content="['main' => $content]"
                />

                {{-- Separate toolbar --}}
                <livewire:ckeditor5-ui-part
                    name="toolbar"
                    editorId="decoupled-editor"
                    class="mb-1"
                />

                {{-- Separate editable area --}}
                <livewire:ckeditor5-editable
                    editorId="{{ $id ?? 'decoupled-editor' }}"
                    class="border-[length:var(--border)] border-neutral rounded-field mx-auto bg-base-200 py-2"
                    editableClass="min-w-[21cm] min-h-[29.7cm] max-w-[21cm] max-h-[29.7cm] mx-auto bg-white"
                    :content="$content"
                    {{ $attributes->merge([]) }}
                />
            BLADE;
    }
}
