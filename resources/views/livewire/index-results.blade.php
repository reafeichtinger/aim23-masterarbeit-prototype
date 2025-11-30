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

                @scope('actions', $testRun)
                    <div class="flex flex-row items-center space-x-2">
                        <x-button icon="o-play" wire:click="continueTestRun('{{ $testRun->hash }}')"
                            wire:loading.attr="disabled" class="btn-sm btn-square btn-ghost text-success"
                            tooltip-left="Testlauf laden" />
                        <x-button icon="o-trash"
                            x-on:click="$dispatch('toggle-delete-confirmation', { hash: '{{ $testRun->hash }}' })"
                            wire:loading.attr="disabled" class="btn-sm btn-square btn-ghost text-error"
                            tooltip-left="Testlauf löschen" />
                    </div>
                @endscope

            </x-table>
        </div>
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
