<x-container>

    {{-- Main content --}}
    <div class="card px-6 py-4 space-y-4 flex flex-col">

        {{-- Header --}}
        <x-header :title="'Editor ' . $this->editor . ' Befragung'" subtitle="Bitte geben Sie kurz Feedback zu Ihrere Erfahrung mit dem Editor.">

            {{-- Timer --}}
            <x-slot:actions>
                <x-timer :timestamp="$this->testRun->started_at" class="text-base-content/50" />
            </x-slot:actions>
        </x-header>

        {{-- Explaination --}}
        <p class="pb-6 max-w-6xl mx-auto">
            Bitte wählen Sie jenen Wert, der Ihre sofortige Antwort auf die gegebenen Aussages widerspiegelt.
            Denken Sie nicht zu lange über jede Aussage nach und stellen Sie sicher, dass Sie zu allen Aussagen eine
            Antwort geben. Alle Fragen haben initial den Wert "0" was bedeutet, dass Sie auch beim vergeben des Wertes
            "1" aktiv auf diesen klicken müssen.
        </p>

        {{-- SUS Questions --}}
        @foreach (App\Enums\SusEnum::options() as $index => $sus)
            <div class="mb-8 bg-base-200 p-4 rounded-box border-(length:--border) border-neutral">
                {{-- Question --}}
                <p class="text-lg font-medium mb-4">
                    {{ $sus['label'] }}
                </p>
                {{-- Range --}}
                <x-range wire:model="answers.{{ $sus['value'] }}" min="1" max="5" step="1"
                    class="range-accent range-xs" />
                {{-- Numbers --}}
                <div class="flex justify-between">
                    <button wire:click="$set('answers.{{ $sus['value'] }}', 1)"
                        class="btn btn-xs text-base font-normal text-base-content/60 -mx-2">1
                    </button>
                    <button wire:click="$set('answers.{{ $sus['value'] }}', 2)"
                        class="btn btn-xs text-base font-normal text-base-content/60 -mx-2">2
                    </button>
                    <button wire:click="$set('answers.{{ $sus['value'] }}', 3)"
                        class="btn btn-xs text-base font-normal text-base-content/60 -mx-2">3
                    </button>
                    <button wire:click="$set('answers.{{ $sus['value'] }}', 4)"
                        class="btn btn-xs text-base font-normal text-base-content/60 -mx-2">4
                    </button>
                    <button wire:click="$set('answers.{{ $sus['value'] }}', 5)"
                        class="btn btn-xs text-base font-normal text-base-content/60 -mx-2">5
                    </button>
                </div>
                {{-- Legend --}}
                <div class="flex justify-between px-1.5 text-sm text-base-content/60">
                    <span>
                        <x-icon name="o-face-frown" class="-ml-1.5" />
                        Ich stimme überhaupt nicht zu
                    </span>
                    <span>
                        Ich stimme voll und ganz zu
                        <x-icon name="o-face-smile" class="-mr-1.5" />
                    </span>
                </div>
            </div>
        @endforeach

        <div class="border-t-(length:--border) border-neutral pb-2"></div>

        {{-- Open questions --}}
        <p class="text-lg font-medium mb-2">
            Teilen Sie uns ein paar Gedanken zu diesem Editor mit. Was fanden Sie gut/schlecht? Denken Sie dass
            dieser Editor für das Verwalten von Dokumenten gut geeignet ist?
            <x-textarea wire:model="answers.question_open" class="min-h-48" />
        </p>

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
                <x-button wire:click="prevStep" class="btn-neutral btn-sm" icon="o-chevron-left" label="Zurück"
                    wire:loading.attr="disabled" />

                {{-- Next step button --}}
                <x-button wire:click="nextStep" class="btn-primary btn-sm" :icon-right="$this->editor == 2 ? 'o-check' : 'o-chevron-right'" :label="$this->editor == 2 ? 'Abschließen' : 'Weiter'"
                    spinner />
            </div>
        </div>
    </div>

</x-container>
