<x-container>
    {{-- Main content --}}
    <div class="card px-6 py-4 space-y-4">
        <x-header title="Willkommen!" subtitle="Das hier ist der Prototyp für die Masterarbeit." />

        Hier werden die Anweisungen für die Aufgabenstellung stehen.

        <x-button :label="session('test-run') ? 'Testlauf fortsetzen' : 'Testlauf starten'" class="btn-primary mt-6" wire:click="start" />
    </div>
</x-container>
