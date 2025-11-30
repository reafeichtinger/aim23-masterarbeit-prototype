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
                <div class="-mt-6 mb-6">
                    @if ($editor == App\Enums\EditorEnum::GRAPESJS)
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
                                    <li>
                                    <span>
                                        Dieser Editor unterstützt Variablen. Anstelle von festgelegtem Text, kann das "Variable" Element verwendet werden, 
                                        welches dynamisch Inhalte wie Kundschaftsdaten verwenden kann. Variablen können wie jedes andere Element in den Editor gezogen werden. 
                                        Diese Variablen können auch in ein Textfeld gezogen werden, um teil des Fließtextes zu werden.
                                    </span>
                                    </li>
                                </ol>
                            </x-slot:content>
                        </x-collapse>

                        @switch($this->step)
                            {{-- Header --}}
                            @case(1)
                            <div class="space-y-2 max-w-6xl mx-auto pb-6">
                                <span class="text-lg text-base-content/50 font-medium mb-2 block">Allgemeine Informationen:</span>
                                <p>
                                    Der aktuelle Editor bietet im Grunde alle klassischen HTML und CSS Möglichkeiten an, wordurch man im Grunde jedes beliebige Layout erstellen kann. 
                                    Zu Beginn kann dies aber ein wenig überfordernd sein oder für Personen ohne Kenntnisse in HTML und CSS Schwierigkeiten bereiten.
                                </p>
                                <p>
                                    Falls Sie Hilfe beim Interagieren mit dem Editor brauchen gibt es ganz oben auf der Seite einen erweiterbaren Reiter "Editor Tipps & Hilfestellungen". 
                                    Zusätzlich gibt es bei groben Problemen die Möglichkeit, Rea um Hilfe zu bitten.
                                </p>
                                <p>
                                    Um einfacher mit dem Editor arbeiten zu können, kann die Sidebar über den "Verkleinern" Button ganz links unten eingeklappt werden, was mehr Platz für den Editor lässt.
                                </p>
                                <p>
                                    Ziel ist es die Vorlage möglichst gleich nachzubilden, dies sollte jedoch so schnell wie möglich durchgeführt werden.
                                    Sobald Sie mit Ihrem Layout zufrieden sind, können Sie auf den "Weiter" Button ganz unten rechts auf der Seite zur nächsten Aufgabe fortfahren.
                                </p>
                                <x-hr />
                                <span class="text-lg text-base-content/50 font-medium mb-2 block">Aufgabenstellung:</span>
                                <p>
                                    Die erste Aufgabe besteht darin, einen Briefkopf zu erstellen, welche mit der DIN-Norm 50008 kompatibel ist.
                                    Der Briefkopf besteht aus Firmendaten, Firmenlogo, Kundschaftsdaten und Rechnungsdaten (Vorlage siehe Bild unten).
                                </p>
                                <p>
                                    Das allgemeine Layout soll mittels Columns (Spalten) und Rows (Zeilen) aufgebaut werden. 
                                    Für Abstände können Padding (Abstände innerhalb eines Elements) und Margin (Abstände außerhalb eines Elements) verwendet werden.
                                </p>
                                <x-hr />
                                <span class="text-lg text-base-content/50 font-medium mb-2 block">Tipps:</span>
                                <ol class="list-decimal pl-4 space-y-4">
                                    <li>
                                        Um die Seitenränder richtig zu konfigurieren wenden Sie folgendes Padding auf dem äußersten Element "Body" an: 
                                        <ul class="list-disc pl-4">
                                            <li>
                                                Oben: 85mm
                                            </li>
                                            <li>
                                                Rechts: 20mm
                                            </li>
                                            <li>
                                                Unten: 30mm
                                            </li>
                                            <li>
                                                Links: 20mm
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        Die beiden Spalten im Briefkopf sind im Verhältnis 70 zu 30 eingestellt.
                                    </li>
                                    <li>
                                        Für die Firmendaten, Kundschaftsdaten und Rechnungsdaten gibt es sogenannte "Variablen", welche als eigenes Element verwendet werden können. 
                                        Dies ist notwendig weil in einem echten Setting, eine Vorlage für ein Rechnungsdokument erstellt werden soll, dementsprechen muss das finale Dokument
                                        immer mit den korrekten Daten für erstellt werden.
                                    </li>
                                    <li>
                                        Das Logo wurde bereits im Projekt hinterlegt und kann ausgewählt werden, wenn das Bild Element verwendet wird. Das Bild bekommt eine Breite von 100%.
                                    </li>
                                </ol>
                            </div>
                            <div class="w-full flex flex-col items-center justify-center bg-[#F7F7F7] rounded-field pt-1 pb-2">
                                <span class="text-base-content/50 max-w-[210mm] w-full text-sm mb-0.5">Vorlage:</span>
                                <img src="{{ asset('img/header.png') }}" alt="" class="max-w-[210mm] rounded-field">
                            </div>
                            @break
                            {{-- Table --}}
                            @case(2)
                                Step Two
                            @break
                            {{-- Text --}}
                            @case(3)
                                Step Three
                            @break
                            {{-- Footer --}}
                            @case(4)
                                Step Four
                            @break
                            {{-- Review and complete --}}
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
