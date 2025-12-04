<x-container>

    {{-- Main content --}}
    <div class="card px-6 py-4 space-y-4">
        <x-header :title="'Testlauf ' . $this->testRun->hash" subtitle="Hier sind alle Details zum ausgewählten Testlauf." />

        {{-- General info --}}
        <div
            class="border-(length:--border) border-neutral rounded-field flex flex-row items-center justify-between w-full p-4 bg-base-200">
            {{-- Initial editor --}}
            <div class="flex flex-col">
                <span class="text-sm font-medium text-base-content/75">Initialer Editor:</span>
                <span class="font-bold">
                    {{ $this->testRun->initial_editor }}
                </span>
            </div>
            {{-- Task count --}}
            <div class="flex flex-col">
                <span class="text-sm font-medium text-base-content/75">Fertige Aufgaben:</span>
                <span class="font-bold">
                    {{ $this->testRun->tasks->where('completed_at', '!=', null)->count() }}
                </span>
            </div>
            {{-- Survey count --}}
            <div class="flex flex-col">
                <span class="text-sm font-medium text-base-content/75">Fertige Befragungen:</span>
                <span class="font-bold">
                    {{ $this->testRun->surveys->where('completed_at', '!=', null)->count() }}
                </span>
            </div>
            {{-- Started at --}}
            <div class="flex flex-col">
                <span class="text-sm font-medium text-base-content/75">Startzeitpunkt:</span>
                <span class="font-bold">
                    {{ App\Utils\DateX::formatDatetime($this->testRun->started_at, default: '-') }}
                </span>
            </div>
            {{-- Completed at --}}
            <div class="flex flex-col">
                <span class="text-sm font-medium text-base-content/75">Endzeitpunkt:</span>
                <span class="font-bold">
                    {{ App\Utils\DateX::formatDatetime($this->testRun->completed_at, default: '-') }}
                </span>
            </div>
            @if ($this->testRun->started_at && $this->testRun->completed_at)
                {{-- Duration --}}
                <div class="flex flex-col">
                    <span class="text-sm font-medium text-base-content/75">Dauer:</span>
                    <span class="font-bold">
                        {{ gmdate('H\h i\m s\s', $this->testRun->started_at?->diffInSeconds($this->testRun->completed_at)) }}
                    </span>
                </div>
            @endif
        </div>
    </div>
</x-container>
