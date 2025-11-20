<x-container>

    {{-- Main content --}}
    <div class="card px-6 py-4 space-y-4 flex flex-col">

        {{-- Header --}}
        <x-header :title="'Editor ' . $this->editor . ' Aufgabe ' . $this->step" subtitle="Bitte führen Sie alle Aufgaben gewissenhaft durch.">

            {{-- Timer --}}
            <x-slot:actions>
                <x-timer :timestamp="$this->testRun->started_at" class="text-base-content/50" />
            </x-slot:actions>
        </x-header>

        {{-- TODO: Load current task info --}}

        @switch($this->testRun->currentEditor)
            @case(App\Enums\EditorEnum::GRAPESJS)
                {{-- GrapesJS Editor --}}
                <x-grapesjs />
            @break

            @default
                {{-- CKEditor 5 --}}
                <x-ckeditor name="document" :value="$this->content" wire:model="content" />
        @endswitch

        {{-- Actions --}}
        <div
            class="border-t-[length:var(--border)] border-neutral px-4 py-2 -mx-6 -mb-4 bg-base-200/50 rounded-b-box flex flex-row justify-between items-center">

            <div>
                {{-- Delete TestRun button --}}
                <x-button wire:click="deleteTestRun" class="btn-error btn-soft btn-sm" icon="o-trash"
                    label="Testlauf abbrechen" />
            </div>

            <div class="space-x-2">

                {{-- Prev step button --}}
                @if ($this->editor > 1 || ($this->editor == 1 && $this->step != 1))
                    <x-button wire:click="prevStep" class="btn-neutral btn-sm" icon="o-chevron-left" label="Zurück" />
                @endif

                {{-- Next step button --}}
                <x-button wire:click="nextStep" class="btn-primary btn-sm" icon-right="o-chevron-right"
                    label="Weiter" />
            </div>
        </div>
    </div>

</x-container>
