<x-container>

    {{-- Main content --}}
    <div class="card px-6 py-4 space-y-4">
        <x-header title="Auswertung" subtitle="Hier sind alle bisher durchgeführten Testläufe." />

        <div class="border-[length:var(--border)] border-neutral rounded-field overflow-hidden">
            <x-table :headers="$this->testRunHeaders" :rows="$this->testRuns" show-empty-text
                emptyText="Es wurden noch keine Testläufe aufgezeichnet...">

                @scope('cell_started_at', $testRun)
                    {{ App\Utils\DateX::formatDateTime($testRun->started_at, withSeconds: true) }}
                @endscope

                @scope('cell_completed_at', $testRun)
                    {{ App\Utils\DateX::formatDateTime($testRun->completed_at, withSeconds: true) }}
                @endscope

            </x-table>
        </div>

    </div>

</x-container>
