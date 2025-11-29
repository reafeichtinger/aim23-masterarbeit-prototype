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

        {{-- Current task info --}}
        <x-task-info :step="$this->step" :editor="$this->testRun->currentEditor" />

        {{-- Editor --}}
        <div>
            @switch($this->testRun->currentEditor)
                @case(App\Enums\EditorEnum::GRAPESJS)
                    {{-- GrapesJS Editor --}}
                    <livewire:components.grapesjs wire:model.live="content" :name="$this->editor . '_' . $this->step" />
                @break

                @default
                    {{-- CKEditor 5 --}}
                    <livewire:components.ckeditor5 wire:model.live="content" :name="$this->editor . '_' . $this->step" />
            @endswitch
        </div>

        {{-- Actions --}}
        <div
            class="border-t-(length:--border) border-neutral px-4 py-2 -mx-6 -mb-4 bg-base-200/50 rounded-b-box flex flex-row justify-between items-center">

            <div>
                {{-- Delete TestRun button --}}
                <x-button x-on:click="$wire.set('showDeleteConfirmation', true)" class="btn-error btn-soft btn-sm"
                    icon="o-trash" label="Testlauf abbrechen" />
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

    {{-- Delete confirmation --}}
    <x-modal wire:model="showDeleteConfirmation" title="Sind Sie sicher?" class="backdrop-blur" box-class="min-w-2xl">
        Wenn du deinen Testlauf abbrichst werden alle zugeordneten Daten gelöscht und Sie verlieren Ihren Fortschritt.
        Dies kann nicht rückgängig gemacht werden.

        <x-slot:actions>
            <div
                class="bg-base-200 flex-1 flex flex-row items-center justify-end space-x-3 -mx-6 -mb-6 p-2 border-t-[length:var(--border)] border-neutral">
                <x-button label="Schließen" x-on:click="$wire.set('showDeleteConfirmation', false)"
                    class="btn-neutral" />
                <x-button wire:click="deleteTestRun" class="btn-error" icon="o-trash" label="Testlauf abbrechen" />
            </div>
        </x-slot:actions>
    </x-modal>

</x-container>
