<?php

namespace App\View\Components;

use App\Enums\EditorEnum;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TaskInfo extends Component
{
    public function __construct(
        public int $step,
        public EditorEnum $editor,
    ) {}

    public function render(): View|Closure|string
    {
        return <<<'BLADE'
                <div class="-mt-6 mb-6 space-y-2">
                    {{-- GrapesJS tipps and tricks --}}
                    <x-collapse class="mb-12">
                        <x-slot:heading>
                            Editor Tipps & Hilfestellungen
                        </x-slot:heading>
                        <x-slot:content>
                            <ol class="list-decimal ml-4 space-y-4">
                                <li>
                                    <span>Dieser Editor funktioniert über Drag & Drop. Elemente können über den</span>
                                    <button class=" inline-flex bg-[#8b5cf6] text-white rounded-sm items-end justify-center mx-2 h-6 w-6 p-1">
                                        <x-icon name="m-plus" class="h-auto w-auto" />
                                    </button> 
                                   <span>Button hinzugefügt werden, indem das gewünschte Element in den Editor gezogen wird.</span>
                                </li>
                                <li>Tea</li>
                                <li>Milk</li>
                            </ol>
                        </x-slot:content>
                    </x-collapse>

                    @if ($editor == App\Enums\EditorEnum::GRAPESJS)
                        {{-- GrapesJS --}}
                        @switch($this->step)
                            @case(1)
                                <p>
                                    Die erste Aufgabe besteht darin, einen Briefkopf zu erstellen.
                                    Der Briefkopf besteht aus Firmendaten, Firmenlogo, Kundschaftsdaten und Rechnungsdaten.
                                </p>
                                <div class="w-full flex flex-row items-center justify-center bg-[#F7F7F7] rounded-field pb-2">
                                    <img src="{{ asset('img/header.png') }}" alt="" class="max-w-[756px]">
                                </div>
                            @break

                            @case(2)
                                Step Two
                            @break

                            @case(3)
                                Step Three
                            @break

                            @case(4)
                                Step Four
                            @break

                            @case(5)
                                Step Five
                            @break

                            @default
                        @endswitch
                    @else
                        {{-- CKEditor5 --}}
                        TODO: CKEditor5
                    @endif
                </div>
            BLADE;
    }
}
