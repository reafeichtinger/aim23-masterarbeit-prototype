<x-layouts.base>

    @php
        // Load current test run and get progress
        $testRun = App\Models\TestRun::where(
            'id',
            Vinkla\Hashids\Facades\Hashids::decode(session('test-run') ?? '')[0] ?? 0,
        )
            ->with('tasks')
            ->first();

        $currentEditor = $testRun?->getNumberFromEditor($testRun->currentEditor);
        $currentStep = $testRun?->currentStep;
    @endphp

    {{-- Mobile navbar --}}
    <x-nav sticky class="lg:hidden">
        <x-slot:actions>
            <label for="main-drawer" class="lg:hidden me-3">
                <x-icon name="o-bars-3-bottom-left" class="cursor-pointer" />
            </label>
        </x-slot:actions>
    </x-nav>

    {{-- Main --}}
    <x-main fullWidth>

        {{-- Sidebar --}}
        <x-slot:sidebar drawer="main-drawer" collapsible
            class="bg-base-100 rounded-e-2xl border-r-[length:var(--border)] border-neutral"
            collapse-icon="o-arrow-left-start-on-rectangle" collapse-text="Verkleinern">

            {{-- Menu --}}
            <x-menu activate-by-route active-bg-color="!bg-secondary/25 !text-secondary-content font-bold"
                class="h-full">

                {{-- Introduction --}}
                <x-menu-item title="Infos & Start" icon="o-information-circle" link="/" />

                {{-- Editors --}}
                <div class="pt-0">

                    {{-- Editor 1 --}}
                    <x-menu-sub title="Editor 1" icon="o-h1" open :disabled="$currentEditor !== 1">

                        <x-menu-item title="Aufgabe 1" :disabled="$currentEditor !== 1 || $currentStep < 1"
                            :link="$testRun ? route('test-run', ['testRun' => $testRun->hash, 'editor' => 1, 'step' => 1]) : null" />

                        <x-menu-item title="Aufgabe 2" :disabled="$currentEditor !== 1 || $currentStep < 2"
                            :link="$testRun ? route('test-run', ['testRun' => $testRun->hash, 'editor' => 1, 'step' => 2]) : null" />

                        <x-menu-item title="Aufgabe 3" :disabled="$currentEditor !== 1 || $currentStep < 3"
                            :link="$testRun ? route('test-run', ['testRun' => $testRun->hash, 'editor' => 1, 'step' => 3]) : null" />

                        <x-menu-item title="Aufgabe 4" :disabled="$currentEditor !== 1 || $currentStep < 4"
                            :link="$testRun ? route('test-run', ['testRun' => $testRun->hash, 'editor' => 1, 'step' => 4]) : null" />

                        <x-menu-item title="Aufgabe 5" :disabled="$currentEditor !== 1 || $currentStep < 5"
                            :link="$testRun ? route('test-run', ['testRun' => $testRun->hash, 'editor' => 1, 'step' => 5]) : null" />

                    </x-menu-sub>

                    {{-- Editor 2 --}}
                    <x-menu-sub title="Editor 2" icon="o-h2" open :disabled="$currentEditor !== 2">

                        <x-menu-item title="Aufgabe 1" :disabled="$currentEditor !== 2 || $currentStep < 1"
                            :link="$testRun ? route('test-run', ['testRun' => $testRun->hash, 'editor' => 2, 'step' => 1]) : null" />

                        <x-menu-item title="Aufgabe 2" :disabled="$currentEditor !== 2 || $currentStep < 2"
                            :link="$testRun ? route('test-run', ['testRun' => $testRun->hash, 'editor' => 2, 'step' => 2]) : null" />

                        <x-menu-item title="Aufgabe 3" :disabled="$currentEditor !== 2 || $currentStep < 3"
                            :link="$testRun ? route('test-run', ['testRun' => $testRun->hash, 'editor' => 2, 'step' => 3]) : null" />

                        <x-menu-item title="Aufgabe 4" :disabled="$currentEditor !== 2 || $currentStep < 4"
                            :link="$testRun ? route('test-run', ['testRun' => $testRun->hash, 'editor' => 2, 'step' => 4]) : null" />

                        <x-menu-item title="Aufgabe 5" :disabled="$currentEditor !== 2 || $currentStep < 5"
                            :link="$testRun ? route('test-run', ['testRun' => $testRun->hash, 'editor' => 2, 'step' => 5]) : null" />

                    </x-menu-sub>

                </div>

                <div class="flex-1"></div>

                {{-- Hidden link to results --}}
                <x-menu-item title="Auswertung" icon="o-presentation-chart-line" class="text-white"
                    :link="route('results')" />

            </x-menu>

        </x-slot:sidebar>

        {{-- Content --}}
        <x-slot:content>
            {{ $slot }}
        </x-slot:content>
    </x-main>

</x-layouts.base>
