<x-container>

    {{-- Main content --}}
    <div class="card px-6 py-4 space-y-6" @attr('wire:poll.5000ms', $this->testRun->completed_at === null)>
        <x-header :title="'Testlauf ' . $this->testRun->hash" subtitle="Hier sind alle Details zum ausgewählten Testlauf.">
            <x-slot:actions>
                <a href="{{ route('results') }}" class="btn btn-sm btn-neutral">
                    <x-icon name="m-arrow-left" />
                    Zurück
                </a>
            </x-slot:actions>
        </x-header>

        {{-- General info --}}
        <span class="collapse-title font-semibold p-0">Allgemeine Informationen:</span>
        <div
            class="border-(length:--border) border-neutral rounded-field flex flex-row items-center justify-between w-full p-4 bg-base-200 mb-8">
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

        <div class="border-t-(length:--border) border-neutral"></div>

        {{-- Tasks --}}
        <x-collapse class="border-transparent" wire:model="showTasks">
            <x-slot:heading class="p-0">
                Aufgaben:
            </x-slot:heading>
            <x-slot:content class="p-0">
                <div class="border-(length:--border) border-neutral rounded-field w-full bg-base-200 mt-3">
                    <x-table :headers="$this->taskHeaders" :rows="$this->testRun->tasks" container-class="w-full">
                        @scope('cell_started_at', $task)
                            {{ App\Utils\DateX::formatDatetime($task->started_at, default: '-') }}
                        @endscope

                        @scope('cell_completed_at', $task)
                            {{ App\Utils\DateX::formatDatetime($task->completed_at, default: '-') }}
                        @endscope

                        @scope('cell_duration', $task)
                            {{ gmdate('H\h i\m s\s', $task->started_at?->diffInSeconds($task->completed_at)) }}
                        @endscope


                        <x-slot:empty>
                            <x-icon name="o-document-text" label="Noch keine Aufgaben durchgeführt." />
                        </x-slot:empty>
                    </x-table>
                </div>
            </x-slot:content>
        </x-collapse>

        <div class="border-t-(length:--border) border-neutral"></div>

        {{-- Surveys --}}
        <x-collapse class="border-transparent" wire:model="showSurveys">
            <x-slot:heading class="p-0">
                Befragungen:
            </x-slot:heading>
            <x-slot:content class="p-0">
                <div class="border-(length:--border) border-neutral rounded-field w-full bg-base-200 mt-3">

                    <x-table :headers="$this->surveyHeaders" :rows="$this->testRun->surveys" container-class="w-full" wire:model="expandedSurveys"
                        expandable>
                        @scope('cell_started_at', $survey)
                            {{ App\Utils\DateX::formatDatetime($survey->started_at, default: '-') }}
                        @endscope

                        @scope('cell_completed_at', $survey)
                            {{ App\Utils\DateX::formatDatetime($survey->completed_at, default: '-') }}
                        @endscope

                        @scope('cell_duration', $survey)
                            {{ gmdate('H\h i\m s\s', $survey->started_at?->diffInSeconds($survey->completed_at)) }}
                        @endscope

                        @scope('expansion', $survey)
                            <table class="w-full">
                                {{-- SUS questions --}}
                                @foreach (App\Enums\SusEnum::labels() as $index => $question)
                                    <tr>
                                        <td class="font-bold">
                                            {{ $question }}
                                        </td>
                                        <td class="text-base text-primary">
                                            {{ $survey->answers['question_' . ($index + 1)] ?? '-' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </table>

                            {{-- Open question --}}
                            <div class="border-t-(length:--border) border-neutral py-3 px-4 space-y-2">
                                <p class="font-bold">
                                    Teilen Sie uns ein paar Gedanken zu diesem Editor mit. Was fanden Sie gut/schlecht?
                                    Denken
                                    Sie dass
                                    dieser Editor für das Verwalten von Dokumenten gut geeignet ist?
                                </p>
                                <p class="text-base text-primary">
                                    {{ $survey->answers['question_open'] ?? '-' }}
                                </p>
                            </div>
                        @endscope

                        <x-slot:empty>
                            <x-icon name="o-document-text" label="Noch keine Befragungen durchgeführt." />
                        </x-slot:empty>
                    </x-table>
                </div>
            </x-slot:content>
        </x-collapse>

        <div class="border-t-(length:--border) border-neutral"></div>

        {{-- Results --}}
        <x-collapse class="border-transparent" wire:model="showResults">
            <x-slot:heading class="p-0">
                Ergebnisse:
            </x-slot:heading>
            <x-slot:content class="p-0">
                <div class="mt-3">
                    @if (!$this->hasGeneratedResults())
                        {{-- Show generate button if one or both pdfs missing --}}
                        @if ($this->testRun->completed_at)
                            <x-button class="btn-primary mt-1" wire:click="generateResults"
                                icon="o-arrow-path-rounded-square" label="Ergebnisse generieren" spinner />
                        @else
                            <x-empty-state title="Testlauf wird bearbeitet...">
                                <x-slot:icon>
                                    <x-loading class="h-16 w-16 loading-dots mb-4 text-base-content/50" />
                                </x-slot:icon>
                                <x-slot:subtitle>
                                    Ergebnisse können erst angezeigt werden, wenn der Testlauf vollständig abgeschlossen
                                    wurde.
                                </x-slot:subtitle>
                            </x-empty-state>
                        @endif
                    @else
                        {{-- Show generated diff --}}
                        <div class="grid grid-cols-12 gap-6 relative">
                            <x-button class="absolute -top-2 right-0 btn-neutral btn-xs" wire:click="generateResults"
                                icon="o-arrow-path-rounded-square" label="Ergebnisse neu generieren" spinner />

                            @foreach (App\Enums\EditorEnum::cases() as $editor)
                                @php
                                    $odiff = $this->testRun->odiffResults->where('editor', $editor->value)->first();
                                @endphp

                                <span class="col-span-full -mb-4">
                                    {{ $editor }}:
                                </span>

                                <x-stat title="Abweichende Pixel" :value="number_format($odiff->pixels, 0, ',', '.')" icon="o-square-3-stack-3d"
                                    color="text-primary"
                                    class="col-span-3 bg-base-200 border-(length:--border) border-neutral" />

                                <x-stat title="Abweichende Zeilen" :value="number_format(count($odiff->lines ?? []), 0, ',', '.')" icon="o-bars-4"
                                    color="text-primary"
                                    class="col-span-3 bg-base-200 border-(length:--border) border-neutral" />

                                <x-stat title="Abweichung in Prozent" :value="number_format($odiff->percent, 2, ',', '.')" icon="o-receipt-percent"
                                    color="text-primary"
                                    class="col-span-3 bg-base-200 border-(length:--border) border-neutral" />

                                <button class="col-span-3 cursor-pointer group"
                                    wire:click="$dispatch('toggle-odiff-modal', { show: true, editor: '{{ $editor->value }}' })">
                                    <x-stat title="Abweichung als Bild" value="anzeigen" icon="o-photo"
                                        color="text-primary"
                                        class="bg-base-200 group-hover:bg-neutral/50 border-(length:--border) border-neutral">
                                    </x-stat>
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>
            </x-slot:content>
        </x-collapse>
    </div>

    {{-- Diff Image modal --}}
    <x-modal wire:model="showOdiff" title="Abweichung als Bild - {{ App\Enums\EditorEnum::parse($this->odiffEditor) }}"
        class="backdrop-blur" box-class="min-w-[210mm]" persistent>

        @if ($this->currentDiff?->hasDiff)
            <img src="{{ $this->currentDiff->img }}" />
        @else
            <x-empty-state title="Keine Unterschiede gefunden"
                subtitle="Dieses Dokument stimmt zu 100% mit der Vorgabe überein!" icon="o-pencil-square">
            </x-empty-state>
        @endif

        <x-slot:actions>
            <div
                class="bg-base-200 flex-1 flex flex-row items-center justify-end space-x-3 -mx-6 -mb-6 p-2 border-t-(length:--border) border-neutral">
                <x-button label="Schließen" wire:click="$dispatch('toggle-odiff-modal', { show: false })"
                    class="btn-neutral" />
            </div>
        </x-slot:actions>
    </x-modal>
</x-container>
