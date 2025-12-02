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
                                        Der Header soll die Position "Fixed" bekommen um auf allen Seiten angezeigt zu werden. Hierfür werden die folgenden Abstände verwendet:
                                        <ul class="list-disc pl-4">
                                            <li>
                                                Oben: 0mm
                                            </li>
                                            <li>
                                                Rechts: 20mm
                                            </li>
                                            <li>
                                                Unten: auto
                                            </li>
                                            <li>
                                                Links: 20mm
                                            </li>
                                        </ul>
                                        Zusätzlich braucht der Header die Darstellung "flex" mit horizontaler Anordnung.
                                    </li>
                                    <li>
                                        Die beiden Spalten im Briefkopf sind im Verhältnis 67.7% zu 33.3% eingestellt. <br/>
                                        Die linke Spalte benötigt ein Padding auf der oberen Seite von 50mm und wird als "flex" angezeigt mit vertikaler Anordnung und linksbündigem Alignment. 
                                        Die Firmendaten haben eine Schriftgröße von 14 px. Die Kundschaftsdaten haben ein Margin oben von 5mm. <br/>
                                        Die rechte Spalte wird ebenfals als "flex" angezeigt mit vertikaler Anordnung und linksbündigem Alignment, jedoch zusätzlich mit einem "justify" Wert "end".
                                    </li>
                                    <li>
                                        Das Logo wurde bereits im Projekt hinterlegt und kann ausgewählt werden, wenn das Bild Element verwendet wird. Das Bild bekommt eine Breite von 100% und einen Margin unten von 20mm.
                                    </li>
                                    <li>
                                        Für die Firmendaten, Kundschaftsdaten und Rechnungsdaten gibt es sogenannte "Variablen", welche als eigenes Element verwendet werden können. 
                                        Dies ist notwendig weil in einem echten Setting, eine Vorlage für ein Rechnungsdokument erstellt werden soll, dementsprechen muss das finale Dokument
                                        immer mit den korrekten Daten für erstellt werden. Diese Variablen können auch in ein Textfeld gezogen werden, um Teil des Fließtextes zu werden.
                                    </li>
                                </ol>
                            </div>
                            <div class="w-full flex flex-col items-center justify-center bg-[#F7F7F7] rounded-field pt-1 pb-2">
                                <span class="text-base-content/50 max-w-[210mm] w-full text-sm mb-0.5">Vorlage:</span>
                                <img src="{{ asset('img/grapesjs_header.png') }}" alt="" class="max-w-[210mm] rounded-field">
                            </div>
                            @break
                            {{-- Table --}}
                            @case(2)
                            <div class="space-y-2 max-w-6xl mx-auto pb-6">
                                <span class="text-lg text-base-content/50 font-medium mb-2 block">Aufgabenstellung:</span>
                                <p>
                                    Die zweite Aufgabe besteht darin, eine Tabelle für die Rechnungspositionen zu erstellen.
                                    Hierbei soll ein Heading, eine Tabelle und die Tabellenzusammenfassung hinzugefügt werden.
                                </p>
                                <p>
                                    Das Tabellen-Element unterstützt aktuell leider keine direkten Schleifen für Zeilen und auch das Styling wird nicht vollständig gespeichert. 
                                    Es ist jedoch dennoch möglich eine Tabelle mit den Rechnungspositionen darzustellen. Hierfür bekommt die Tabelle zwei Zeilen, eine Header-Zeile und eine für den Inhalt.
                                    In jeder Spalte der Inhalts-Zeile wird dann eine Schleife für die Positionen verwendet mit dem entsprechenden Wert der Rechnungsposition.
                                </p>
                                <x-hr />
                                <span class="text-lg text-base-content/50 font-medium mb-2 block">Tipps:</span>
                                <ol class="list-decimal pl-4 space-y-4">
                                    <li>
                                        Das Heading hat eine Größe von 2rem und soll in der Farbe Schwarz <span class="bg-neutral px-1.5 py-0.5 rounded-field text-sm text-base-content/75">rgba(0, 0, 0, 1)</span> angezeigt werden.
                                    </li>
                                    <li>
                                        Das Tabellen-Element bekommt einen Margin oben von 1cm. Die Spalten im Header bekommen ein Padding oben und unten von 4px. 
                                        Die "Einzelpreis" Spalte hat zentrierten Text und die "Betrag" Spalte rechtsbündigen.
                                    </li>
                                    <li>
                                        Die einzelnen Spalten der Content Zeile bekommen jeweils eine Schleife, welche über <strong>alle</strong> Rechnungspositionen iteriert. 
                                        Das Schleifenelement ist eine Variable, welches auf den jewiligen Wert der Spalte zugreift.
                                    </li>
                                    <li>
                                        Der Footer der Tabelle wird als vertikaler "flex" angezeigt und verwendet das Alignment "end". Das Padding oben & unten beträgt 10px.
                                        Das Column im Footer bekommt eine Breite von 33% und eine doppelte Border von 3px am oberen Rand. In diesem Column gibt es zwei Reihen,
                                        diese werden als horizontaler "flex" angezeigt, haben einen Justify Wert "space between", ein Alignment "center" und ein Padding oben und unten von 4px.
                                        Die Variable benötigt einen Flex Wert "hug contents" um nur den benötigten Platz zu verbrauchen.
                                    </li>
                                </ol>
                            </div>
                            <div class="w-full flex flex-col items-center justify-center bg-[#F7F7F7] rounded-field pt-1 pb-2">
                                <span class="text-base-content/50 max-w-[210mm] w-full text-sm mb-0.5">Vorlage:</span>
                                <img src="{{ asset('img/grapesjs_table.png') }}" alt="" class="max-w-[210mm] rounded-field">
                            </div>
                            @break
                            {{-- Text --}}
                            @case(3)
                            <div class="space-y-2 max-w-6xl mx-auto pb-6">
                                <span class="text-lg text-base-content/50 font-medium mb-2 block">Aufgabenstellung:</span>
                                <p>
                                    Die dritte Aufgabe besteht darin, den Text des Rechnungsdokuments zu erstellen.
                                    Hierbei soll ein neues Column angelegt werden in dem sich die Begrüßung, der Inhalt mit dem Fälligkeitsdatum der Rechnung und die Signatur befindet.
                                </p>
                                <x-hr />
                                <span class="text-lg text-base-content/50 font-medium mb-2 block">Tipps:</span>
                                <ol class="list-decimal pl-4 space-y-4">
                                    <li>
                                        Das Column hat einen Margin oben von 1cm und wird als vertikaler "flex" angezeigt mit einer "Gap" von 16px zwischen der Begrüßung, dem Inhalt und der Signatur.
                                    </li>
                                    <li>
                                        Hier ist der Text zum Kopieren, die Variablen müssen manuell ersetzt werden:
                                        <p class="text-base-content/50 mt-2">
                                            Hallo [[ globalData.recipient.data.name ]]!<br/><br/>
                                            Vielen Dank für Ihre Bestellung und Ihr Vertrauen. Bitte begleichen Sie den offenen Rechnungsbetrag bis [[ globalData.invoice.data.dueDate ]]auf das in der Fußzeile angegebene Konto.<br/><br/>
                                            Mit freundlichen Grüßen <br/>
                                            Ihre [[ globalData.operator.data.name ]]
                                        </p>
                                    </li>
                                </ol>
                            </div>
                            <div class="w-full flex flex-col items-center justify-center bg-[#F7F7F7] rounded-field pt-1 pb-2">
                                <span class="text-base-content/50 max-w-[210mm] w-full text-sm mb-0.5">Vorlage:</span>
                                <img src="{{ asset('img/grapesjs_text.png') }}" alt="" class="max-w-[210mm] rounded-field">
                            </div>
                            @break
                            {{-- Footer --}}
                            @case(4)
                            <div class="space-y-2 max-w-6xl mx-auto pb-6">
                                <span class="text-lg text-base-content/50 font-medium mb-2 block">Aufgabenstellung:</span>
                                <p>
                                    Die vierte Aufgabe besteht darin, den Footer des Rechnungsdokuments zu erstellen.
                                    Der Footer besteht aus Kontaktdaten und der Bankverbindung der Firma. Diese Werte sollen ebenfalls wieder als Variablen angelegt werden.
                                </p>
                                <x-hr />
                                <span class="text-lg text-base-content/50 font-medium mb-2 block">Tipps:</span>
                                <ol class="list-decimal pl-4 space-y-4">
                                    <li>
                                        Gleich wie beim Header auch, soll der Footer die Positionierung "Fixed" bekommen und die folgenden Werte für die Abstände verwenden:
                                        <ul class="list-disc pl-4">
                                            <li>
                                                Oben: auto
                                            </li>
                                            <li>
                                                Rechts: 0mm
                                            </li>
                                            <li>
                                                Unten: 0mm
                                            </li>
                                            <li>
                                                Links: 0mm
                                            </li>
                                        </ul>
                                        Der Footer soll als horizontaler "flex" angezeigt werden mit einem "Justify" Wert von "space evenly" und einem Alignment "center". 
                                        Ebenfalls hat der Footer ein Padding oben und unten von 5mm und eine solide Border an der oberen Seite mit 1px Breite.
                                    </li>
                                    <li>
                                        Die beiden Spalten werden auf die gleiche Weise konfiguriert. Anzeige als vertikaler "flex" mit einem Flex Wert "hug contents" und einer Schriftgröße von 12px.
                                        Ich empfehle zuerst die linke Spalte anzulegen und zu befüllen, danach kann diese dupliziert werden.
                                    </li>
                                    <li>
                                        Innerhalb der Spalte gibt es ein kleines Heading mit 14px Textgröße und 6px Margin unten.
                                    </li>
                                </ol>
                            </div>
                            <div class="w-full flex flex-col items-center justify-center bg-[#F7F7F7] rounded-field pt-1 pb-2">
                                <span class="text-base-content/50 max-w-[210mm] w-full text-sm mb-0.5">Vorlage:</span>
                                <img src="{{ asset('img/grapesjs_footer.png') }}" alt="" class="max-w-[210mm] rounded-field">
                            </div>
                            @break
                            {{-- Review and complete --}}
                            @case(5)
                            <div class="space-y-2 max-w-6xl mx-auto pb-6">
                                <span class="text-lg text-base-content/50 font-medium mb-2 block">Aufgabenstellung:</span>
                                Im letzen Schritt können sie das gesamte Layout nocheinmal überarbeiten um möglichst genau die Vorlage abzubilden. 
                                Wenn Sie zufrieden mit ihrem Dokument sind drücken Sie einfach den "Weiter" Button um zum nächsten Editor zu kommen oder den Testlauf abzuschließen.
                            </div>
                            <div class="w-full flex flex-col items-center justify-center bg-[#F7F7F7] rounded-field pt-1 pb-2">
                                <span class="text-base-content/50 max-w-[210mm] w-full text-sm mb-0.5">Vorlage:</span>
                                <img src="{{ asset('img/grapesjs.png') }}" alt="" class="max-w-[210mm] rounded-field">
                            </div>
                            @break
                            @default
                        @endswitch
                    @else
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
                            </div>
                            @break
                            @default
                        @endswitch
                    @endif
                </div>
            BLADE;
    }
}
