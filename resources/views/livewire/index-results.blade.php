<x-container>

    {{-- Main content --}}
    <div class="card px-6 py-4 space-y-4" @attr('wire:poll.5000ms', $this->testRuns->where('completed_at', null)->count())>
        <x-header title="Auswertung" subtitle="Hier sind alle bisher durchgeführten Testläufe.">
            <x-slot:actions>
                @if (config('app.admin-password') && $this->unlocked)
                    <x-button class="btn-sm btn-neutral" icon="o-lock-closed" label="Sperren" wire:click="lock" />
                @endif
            </x-slot:actions>
        </x-header>

        @if ($this->unlocked)
            {{-- Test run overview --}}
            <div class="border-(length:--border) border-neutral rounded-field overflow-hidden">
                <x-table :headers="$this->testRunHeaders" :rows="$this->testRuns" show-empty-text
                    emptyText="Es wurden noch keine Testläufe aufgezeichnet..." :row-decoration="[
                        'bg-primary/10 hover:bg-primary/15' => fn($testRun) => $testRun->hash ==
                            session('test-run.hash'),
                    ]">

                    @scope('cell_started_at', $testRun)
                        <span class="whitespace-nowrap">
                            {{ App\Utils\DateX::formatDateTime($testRun->started_at, withSeconds: true) }}
                        </span>
                    @endscope

                    @scope('cell_completed_at', $testRun)
                        <span class="whitespace-nowrap">
                            {{ App\Utils\DateX::formatDateTime($testRun->completed_at, withSeconds: true) }}
                        </span>
                    @endscope

                    @scope('cell_duration', $testRun)
                        <span class="whitespace-nowrap">
                            {{ gmdate('H\h i\m s\s', $testRun->started_at?->diffInSeconds($testRun->completed_at)) }}
                            ({{ round($testRun->started_at?->diffInSeconds($testRun->completed_at)) }} sek)
                        </span>
                    @endscope

                    @scope('actions', $testRun)
                        <div class="flex flex-row justify-end items-center space-x-2">
                            {{-- Deselect  --}}
                            @if ($testRun->hash == session('test-run.hash'))
                                <x-button icon="o-stop" wire:click="deselectTestRun" wire:loading.attr="disabled"
                                    class="btn-sm btn-square btn-ghost text-warning" tooltip-left="Testlauf abwählen" />
                            @endif
                            {{-- Continue --}}
                            <x-button icon="o-play" wire:click="continueTestRun('{{ $testRun->hash }}')"
                                wire:loading.attr="disabled" class="btn-sm btn-square btn-ghost text-success"
                                tooltip-left="Testlauf laden" />
                            {{-- Delete --}}
                            <x-button icon="o-trash"
                                x-on:click="$dispatch('toggle-delete-confirmation', { hash: '{{ $testRun->hash }}' })"
                                wire:loading.attr="disabled" class="btn-sm btn-square btn-ghost text-error"
                                tooltip-left="Testlauf löschen" />
                            {{-- Details --}}
                            <a href="{{ route('show-result', ['testRun' => $testRun->hash]) }}" class="btn btn-link">
                                Details
                            </a>
                        </div>
                    @endscope
                </x-table>
                <div
                    class="w-full border-t-(length:--border) border-neutral text-right pr-8 py-1 text-base-content/50 font-medium bg-base-200">
                    Gesamt:
                    {{ $this->testRuns->count() }}
                </div>
            </div>
        @else
            {{-- Password prompt --}}
            <x-empty-state title="Um auf die Auswertung zuzugreifen musst du zuerst das Passwort eingeben."
                icon="o-lock-closed">
                <x-slot:subtitle>
                    <div class="text-left w-1/3 mt-6">

                        <x-password label="Passwort" class="text-left w-full" wire:model="password" />

                    </div>

                    <x-button label="Entsperren" icon-right="o-lock-open" class="btn-primary mt-6"
                        wire:click="unlock" />
                </x-slot:subtitle>
            </x-empty-state>
        @endif
    </div>

    {{-- Delete confirmation --}}
    <x-modal wire:model="showDeleteConfirmation" title="Sind Sie sicher?" class="backdrop-blur" box-class="min-w-2xl">
        Der Testlauf wird gelöscht, dies kann nicht rückgängig gemacht werden.

        <x-slot:actions>
            <div
                class="bg-base-200 flex-1 flex flex-row items-center justify-end space-x-3 -mx-6 -mb-6 p-2 border-t-[length:var(--border)] border-neutral">
                <x-button label="Schließen" x-on:click="$dispatch('toggle-delete-confirmation')" class="btn-neutral" />
                <x-button wire:click="deleteTestRun" class="btn-error" icon="o-trash" label="Testlauf abbrechen" />
            </div>
        </x-slot:actions>
    </x-modal>

</x-container>
