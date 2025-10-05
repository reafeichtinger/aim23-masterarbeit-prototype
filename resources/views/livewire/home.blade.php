<x-container>
    {{-- Main content --}}
    <div class="card px-6 py-4 space-y-4">
        <x-header title="Willkommen!" subtitle="Das hier ist der Prototyp für die Masterarbeit." />

        Hier werden die Anweisungen für die Aufgabenstellung stehen.

    </div>

    {{-- Right side content --}}
    <x-slot:right>
        <div class="card px-4 py-2">
            Optional kann hier auch etwas angezeigt werden.
        </div>
    </x-slot:right>
</x-container>
