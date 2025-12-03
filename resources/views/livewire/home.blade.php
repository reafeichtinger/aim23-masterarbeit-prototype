<x-container>
    {{-- Main content --}}
    <div class="card px-6 py-4 space-y-4">
        @if (!$this->completed)
            {{-- Start a new test run --}}
            <x-header title="Willkommen!" subtitle="Das hier ist der Prototyp für die Masterarbeit." />

            Hier werden die Anweisungen für die Aufgabenstellung stehen.

            <x-button :label="session('test-run.hash') ? 'Testlauf fortsetzen' : 'Testlauf starten'" class="btn-primary mt-6" icon-right="o-play" wire:click="start" spinner />
        @else
            {{-- Congrats on finishing --}}
            <x-header title="Vielen Dank!" subtitle="Danke dass du an diesem Test teilgenommen hast." />

            <div class="text-3xl font-bold text-center my-24">
                Du hast
                {{ gmdate('H\h i\m s\s', $this->testRun?->started_at?->diffInSeconds(now())) ?? 'ja gar nicht so lange' }}
                gebraucht.

                {{-- Confetti --}}
                <div x-data="{
                    init() {
                            this.schedule();
                        },
                        schedule() {
                            setTimeout(() => this.pop(), 1000 * (Math.random() * 3)); // * (Math.random() * 3)
                        },
                        pop() {
                            $confetti();
                            this.schedule();
                        }
                }" class="w-full" x-cloak></div>
            </div>

            <x-button label="Ich bin fertig" class="btn-primary" icon-right="o-hand-thumb-up" wire:click="resetTestRun"
                spinner />
        @endif

    </div>
</x-container>
