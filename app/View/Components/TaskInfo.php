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
                        @switch($this->step)
                            {{-- Header --}}
                            @case(1)
                            <div class="space-y-2 max-w-6xl mx-auto pb-6">
                                <span class="text-lg text-base-content/50 font-medium mb-2 block">Allgemeine Informationen:</span>
                                <p>
                                    Der aktuelle Editor bietet alle klassischen HTML und CSS Möglichkeiten an, wordurch man im Grunde jedes beliebige Layout erstellen kann. 
                                    Zu Beginn kann dies aber ein wenig überfordernd sein oder für Personen ohne Kenntnisse in HTML und CSS Schwierigkeiten bereiten.
                                </p>
                                <p>
                                    Falls Sie Hilfe beim Interagieren mit dem Editor brauchen, gibt es pro Aufgabenstellung ein paar Tipps um die Vorlage möglichst genau nachzustellen.
                                    Zusätzlich gibt es bei groben Problemen die Möglichkeit, Rea um Hilfe zu bitten.
                                </p>
                                <p>
                                    Um einfacher mit dem Editor arbeiten zu können, kann die Sidebar über den <x-icon name="o-arrow-left-start-on-rectangle" /> "Verkleinern" Button 
                                    ganz links unten eingeklappt werden, was mehr Platz für den Editor lässt.
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
                                        <span>Dieser Editor funktioniert über Drag & Drop. Elemente können über den</span>
                                        <button class=" inline-flex bg-[#8b5cf6] text-white rounded-sm items-end justify-center mx-2 h-6 w-6 p-1">
                                            <x-icon name="m-plus" class="h-auto w-auto" />
                                        </button> 
                                       <span>Button hinzugefügt werden, indem das gewünschte Element in den Editor gezogen wird.</span>
                                    </li>
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
                                    Das Tabellen-Element unterstützt aktuell leider keine Schleifen für Zeilen und auch das Styling wird nicht vollständig gespeichert. 
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
                                        Die "Einzelpreis" Spalte hat zentrierten Text und die "Betrag" Spalte hat rechtsbündigen Text.
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
                                            Vielen Dank für Ihre Bestellung und Ihr Vertrauen. Bitte begleichen Sie den offenen Rechnungsbetrag bis [[ globalData.invoice.data.dueDate ]] auf das in der Fußzeile angegebene Konto.<br/><br/>
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
                                Im letzen Schritt können sie das gesamte Layout nocheinmal überarbeiten um möglichst genau die Vorlage abzubilden. Um das finale Layout als PDF-Datei zu überprüfen können Sie den 
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="display: inline;width: 1.25rem; height: 1.25rem; fill: currentcolor;"><path d="M18 3H6v4h12m1 5a1 1 0 0 1-1-1 1 1 0 0 1 1-1 1 1 0 0 1 1 1 1 1 0 0 1-1 1m-3 7H8v-5h8m3-6H5a3 3 0 0 0-3 3v6h4v4h12v-4h4v-6a3 3 0 0 0-3-3Z"></path></svg>
                                Button in der Titelleiste des Editors drücken. <br/>
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
                                    Der aktuelle Editor bietet ein einfaches Interface an um grundlegende Dokumente zu erstellen. 
                                    Durch das simple Interface hat man jedoch auch nur eingeschränkt Kontrolle über die genaue Darstellung und Anordnung der Inhalte.
                                </p>
                                <p>
                                    Falls Sie Hilfe beim Interagieren mit dem Editor brauchen, gibt es pro Aufgabenstellung ein paar Tipps um die Vorlage möglichst genau nachzustellen.
                                    Zusätzlich gibt es bei groben Problemen die Möglichkeit, Rea um Hilfe zu bitten.
                                </p>
                                <p>
                                    Um einfacher mit dem Editor arbeiten zu können, kann die Sidebar über den "Verkleinern" Button ganz links unten eingeklappt werden, was mehr Platz für den Editor lässt.
                                </p>
                                <p>
                                    Ziel ist es die Vorlage möglichst gleich nachzubilden, dies sollte jedoch so schnell wie möglich durchgeführt werden.
                                    Sobald Sie mit Ihrem Layout zufrieden sind, können Sie auf den "Weiter" Button ganz unten rechts auf der Seite zur nächsten Aufgabe fortfahren.<br/>
                                    Weil das Layout dieses Editors nicht zu 100% mit der generierten .pdf übereinstimmt, können Sie zur Überprüfung des Layouts den <x-icon name="o-printer" />
                                    Button drücken.
                                </p>
                                <x-hr />
                                <span class="text-lg text-base-content/50 font-medium mb-2 block">Aufgabenstellung:</span>
                                <p>
                                    Die erste Aufgabe besteht darin, einen Briefkopf zu erstellen, welche mit der DIN-Norm 50008 kompatibel ist.
                                    Der Briefkopf besteht aus Firmendaten, Firmenlogo, Kundschaftsdaten und Rechnungsdaten (Vorlage siehe Bild unten).
                                </p>
                                <x-hr />
                                <span class="text-lg text-base-content/50 font-medium mb-2 block">Tipps:</span>
                                <ol class="list-decimal pl-4 space-y-4">
                                    <li>
                                        Das allgemeine Layout des Headers kann mithilfe einer sogenannten Tabellenlayout angelegt werden, 
                                        klicken Sie hierfür in der oberen Menü-Leiste auf "Einfügen" und wählen Sie ein Tabellenlayout mit zwei Spalten und einer Zeile aus.
                                    </li>
                                    <li>
                                        Die linke Spalte des Tabellenlayouts bekommt eine Breite von 65% und eine Ausrichtung von unten, die rechte 35% und ebenfalls eine Ausrichtung von unten.
                                    </li>
                                    <li>
                                        Variablen, bzw. "Seriendruckfelder" können verwendet werden, um dynamische Daten einzufügen. Hierfür können Sie den 
                                        <svg class="inline h-5! w-5! ck ck-icon ck-reset_all-excluded ck-icon_inherit-color ck-button__icon" viewBox="0 0 20 20" aria-hidden="true"><circle cx="10" cy="9.8" r="1.5"></circle><path d="M13.25 2.75V2h.035a6 6 0 0 1 .363.014c.21.013.517.041.785.109.397.1.738.281 1.007.55s.429.587.524.907c.182.608.15 1.314.108 1.913l-.03.408c-.038.487-.073.93-.053 1.353.026.527.136.879.333 1.112.223.263.494.428.72.528a2 2 0 0 0 .335.117l.01.002.613.109v.628h-2.402a3.3 3.3 0 0 1-.42-.415c-.509-.601-.655-1.345-.687-2.009-.025-.527.02-1.094.059-1.592l.026-.347c.044-.621.044-1.067-.049-1.377a.63.63 0 0 0-.148-.276.64.64 0 0 0-.313-.157 3 3 0 0 0-.512-.066 6 6 0 0 0-.286-.01h-.016L13.25 3.5h-.75V2h.75z"></path><path d="M13.25 16.75v.75h.035a7 7 0 0 0 .363-.014 4.6 4.6 0 0 0 .785-.109c.397-.1.738-.28 1.007-.55.268-.269.429-.587.524-.907.182-.608.15-1.314.108-1.912l-.03-.41c-.038-.486-.073-.93-.053-1.352.026-.527.136-.879.333-1.112.223-.263.494-.428.72-.528a2 2 0 0 1 .335-.117l.01-.002.613-.109V9.75h-2.402a3.3 3.3 0 0 0-.42.416c-.509.6-.655 1.344-.687 2.008-.025.527.02 1.095.059 1.592l.026.347c.044.621.044 1.067-.049 1.378a.63.63 0 0 1-.148.275.64.64 0 0 1-.313.157 3 3 0 0 1-.512.066 6 6 0 0 1-.286.01l-.016.001H12.5v1.5h.75zm-6.5-14V2h-.035a6 6 0 0 0-.363.014 4.6 4.6 0 0 0-.785.109 2.13 2.13 0 0 0-1.008.55 2.1 2.1 0 0 0-.524.907c-.181.608-.15 1.314-.108 1.913l.031.408c.038.487.073.93.052 1.353-.025.527-.136.879-.333 1.112a2 2 0 0 1-.718.528 2 2 0 0 1-.337.117l-.01.002L2 9.122v.628h2.402a3.3 3.3 0 0 0 .42-.415c.509-.601.654-1.345.686-2.009.026-.527-.019-1.094-.058-1.592q-.015-.18-.026-.347c-.044-.621-.044-1.067.048-1.377a.63.63 0 0 1 .149-.276.64.64 0 0 1 .312-.157c.13-.032.323-.054.513-.066a6 6 0 0 1 .286-.01h.015L6.75 3.5h.75V2h-.75zm0 14v.75h-.035a7 7 0 0 1-.363-.014 4.6 4.6 0 0 1-.785-.109 2.13 2.13 0 0 1-1.008-.55 2.1 2.1 0 0 1-.524-.907c-.181-.608-.15-1.314-.108-1.912l.031-.41c.038-.486.073-.93.052-1.352-.025-.527-.136-.879-.333-1.112a2 2 0 0 0-.718-.528 2 2 0 0 0-.337-.117l-.01-.002L2 10.378V9.75h2.402q.218.178.42.416c.509.6.654 1.344.686 2.008.026.527-.019 1.095-.058 1.592q-.015.18-.026.347c-.044.621-.044 1.067.048 1.378a.63.63 0 0 0 .149.275.64.64 0 0 0 .312.157c.13.032.323.054.513.066a6 6 0 0 0 .286.01l.015.001H7.5v1.5h-.75z"></path></svg> 
                                        Button drücken.
                                    </li>
                                    <li>
                                        Die Firmendetails bekommen die Schriftgröße "Klein" und werden unterstrichen. 
                                        Unter den Firmendetails soll eine leere Zeile eingefügt werden um den nötigen Abstand zu den Kundschaftsdaten zu erreichen.
                                    </li>
                                    <li>
                                        Das Logo ist bereits im Editor hinterlegt und kann über den 
                                        <svg class="inline h-5! w-5! ck ck-icon ck-reset_all-excluded ck-icon_inherit-color ck-button__icon" viewBox="0 0 20 20" aria-hidden="true"><path d="M8 0H3a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h5a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2M2.5 2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 .5.5v15a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5zM13 0h5a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-5a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2m0 1.5a.5.5 0 0 0-.5.5v5a.5.5 0 0 0 .5.5h5a.5.5 0 0 0 .5-.5V2a.5.5 0 0 0-.5-.5zm0 8.5h5a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-5a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2m0 1.5a.5.5 0 0 0-.5.5v5a.5.5 0 0 0 .5.5h5a.5.5 0 0 0 .5-.5v-5a.5.5 0 0 0-.5-.5z" clip-rule="evenodd"></path></svg>
                                        Button eingefügt werden. Unter dem Logo sollen 3 leere Zeilen eingefügt werden um den nötigen Abstand zu den Werten zu erreichen.
                                    </li>
                                </ol>
                            </div>
                            <div class="w-full flex flex-col items-center justify-center bg-[#F7F7F7] rounded-field pt-1 pb-2">
                                <span class="text-base-content/50 max-w-[210mm] w-full text-sm mb-0.5">Vorlage:</span>
                                <img src="{{ asset('img/ckeditor_header.png') }}" alt="" class="max-w-[210mm] rounded-field">
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
                                    Weil dieser Editor keine Schleifen unterstützt, wurde die gesamte Tabelle als Variable definiert und kann direkt eingefügt werden. 
                                    Sie können diese in den Seriendruckfeldern
                                    <svg class="inline h-5! w-5! ck ck-icon ck-reset_all-excluded ck-icon_inherit-color ck-button__icon" viewBox="0 0 20 20" aria-hidden="true"><circle cx="10" cy="9.8" r="1.5"></circle><path d="M13.25 2.75V2h.035a6 6 0 0 1 .363.014c.21.013.517.041.785.109.397.1.738.281 1.007.55s.429.587.524.907c.182.608.15 1.314.108 1.913l-.03.408c-.038.487-.073.93-.053 1.353.026.527.136.879.333 1.112.223.263.494.428.72.528a2 2 0 0 0 .335.117l.01.002.613.109v.628h-2.402a3.3 3.3 0 0 1-.42-.415c-.509-.601-.655-1.345-.687-2.009-.025-.527.02-1.094.059-1.592l.026-.347c.044-.621.044-1.067-.049-1.377a.63.63 0 0 0-.148-.276.64.64 0 0 0-.313-.157 3 3 0 0 0-.512-.066 6 6 0 0 0-.286-.01h-.016L13.25 3.5h-.75V2h.75z"></path><path d="M13.25 16.75v.75h.035a7 7 0 0 0 .363-.014 4.6 4.6 0 0 0 .785-.109c.397-.1.738-.28 1.007-.55.268-.269.429-.587.524-.907.182-.608.15-1.314.108-1.912l-.03-.41c-.038-.486-.073-.93-.053-1.352.026-.527.136-.879.333-1.112.223-.263.494-.428.72-.528a2 2 0 0 1 .335-.117l.01-.002.613-.109V9.75h-2.402a3.3 3.3 0 0 0-.42.416c-.509.6-.655 1.344-.687 2.008-.025.527.02 1.095.059 1.592l.026.347c.044.621.044 1.067-.049 1.378a.63.63 0 0 1-.148.275.64.64 0 0 1-.313.157 3 3 0 0 1-.512.066 6 6 0 0 1-.286.01l-.016.001H12.5v1.5h.75zm-6.5-14V2h-.035a6 6 0 0 0-.363.014 4.6 4.6 0 0 0-.785.109 2.13 2.13 0 0 0-1.008.55 2.1 2.1 0 0 0-.524.907c-.181.608-.15 1.314-.108 1.913l.031.408c.038.487.073.93.052 1.353-.025.527-.136.879-.333 1.112a2 2 0 0 1-.718.528 2 2 0 0 1-.337.117l-.01.002L2 9.122v.628h2.402a3.3 3.3 0 0 0 .42-.415c.509-.601.654-1.345.686-2.009.026-.527-.019-1.094-.058-1.592q-.015-.18-.026-.347c-.044-.621-.044-1.067.048-1.377a.63.63 0 0 1 .149-.276.64.64 0 0 1 .312-.157c.13-.032.323-.054.513-.066a6 6 0 0 1 .286-.01h.015L6.75 3.5h.75V2h-.75zm0 14v.75h-.035a7 7 0 0 1-.363-.014 4.6 4.6 0 0 1-.785-.109 2.13 2.13 0 0 1-1.008-.55 2.1 2.1 0 0 1-.524-.907c-.181-.608-.15-1.314-.108-1.912l.031-.41c.038-.486.073-.93.052-1.352-.025-.527-.136-.879-.333-1.112a2 2 0 0 0-.718-.528 2 2 0 0 0-.337-.117l-.01-.002L2 10.378V9.75h2.402q.218.178.42.416c.509.6.654 1.344.686 2.008.026.527-.019 1.095-.058 1.592q-.015.18-.026.347c-.044.621-.044 1.067.048 1.378a.63.63 0 0 0 .149.275.64.64 0 0 0 .312.157c.13.032.323.054.513.066a6 6 0 0 0 .286.01l.015.001H7.5v1.5h-.75z"></path></svg> 
                                    als "Rechnungstabelle" finden.
                                </p>
                                <x-hr />
                                <span class="text-lg text-base-content/50 font-medium mb-2 block">Tipps:</span>
                                <ol class="list-decimal pl-4 space-y-4">
                                    <li>
                                        Das Heading soll als "Überschrift 1" markiert werden.<br/>
                                        Zwischen dem Heading und der Tabelle befindet sich eine leere Zeile in normaler Größe.
                                    </li>
                                    <li>
                                        Für den Footer der Tabelle benötigen Sie ein Tabellenlayout mit einer Zeile und einer Spalte. 
                                        Dieses bekommt eine Breite von 35% und eine Ausrichtung nach rechts.
                                    </li>
                                    <li>
                                        Weil der Editor keine seitenspezifischen Ränder unterstützt gibt es die Vorlage "doppelte Linie", welche Sie über den 
                                        <svg class="inline h-5! w-5! ck ck-icon ck-reset_all-excluded ck-icon_inherit-color ck-button__icon" viewBox="0 0 20 20" aria-hidden="true"><path d="M8 0H3a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h5a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2M2.5 2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 .5.5v15a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5zM13 0h5a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-5a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2m0 1.5a.5.5 0 0 0-.5.5v5a.5.5 0 0 0 .5.5h5a.5.5 0 0 0 .5-.5V2a.5.5 0 0 0-.5-.5zm0 8.5h5a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-5a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2m0 1.5a.5.5 0 0 0-.5.5v5a.5.5 0 0 0 .5.5h5a.5.5 0 0 0 .5-.5v-5a.5.5 0 0 0-.5-.5z" clip-rule="evenodd"></path></svg>
                                        Button in das neue Tabellenlayout einfügen können.
                                    </li>
                                    <li>
                                        Unter der doppelten Trennlinie befindet sich eine Inhaltstabelle mit zwei Zeilen und zwei Spalten. 
                                        Alle Zellen bekommen einen Innenabstand von 2px, die rechte Spalte wird nach rechts ausgerichtet.
                                    </li>
                                </ol>
                            </div>
                            <div class="w-full flex flex-col items-center justify-center bg-[#F7F7F7] rounded-field pt-1 pb-2">
                                <span class="text-base-content/50 max-w-[210mm] w-full text-sm mb-0.5">Vorlage:</span>
                                <img src="{{ asset('img/ckeditor_table.png') }}" alt="" class="max-w-[210mm] rounded-field">
                            </div>
                            @break
                            {{-- Text --}}
                            @case(3)
                            <div class="space-y-2 max-w-6xl mx-auto pb-6">
                                <span class="text-lg text-base-content/50 font-medium mb-2 block">Aufgabenstellung:</span>
                                <p>
                                    Die dritte Aufgabe besteht darin, den Text des Rechnungsdokuments zu erstellen.
                                    Hierbei soll der Text unterhalb des Tabellenfooters angelegt werden in dem sich die Begrüßung, der Inhalt mit dem Fälligkeitsdatum der Rechnung und die Signatur befindet.
                                </p>
                                <x-hr />
                                <span class="text-lg text-base-content/50 font-medium mb-2 block">Tipps:</span>
                                <ol class="list-decimal pl-4 space-y-4">
                                    <li>
                                        Vom Tabellenfooter aus gesehen werden 7 leere Zeilen benötigt um einen entsprechenden Abstand unterhalb zu erzielen.
                                    </li>
                                    <li>
                                        Hier ist der Text zum Kopieren, die Variablen müssen manuell ersetzt werden:
                                        <p class="text-base-content/50 mt-2">
                                            Hallo [[ Kund:in Name ]]!<br/><br/>
                                            Vielen Dank für Ihre Bestellung und Ihr Vertrauen. Bitte begleichen Sie den offenen Rechnungsbetrag bis [[ Rechnungsfälligkeitsdatum ]] auf das in der Fußzeile angegebene Konto.<br/><br/>
                                            Mit freundlichen Grüßen <br/>
                                            Ihre [[ Firmenname ]]
                                        </p>
                                    </li>
                                </ol>
                            </div>
                            <div class="w-full flex flex-col items-center justify-center bg-[#F7F7F7] rounded-field pt-1 pb-2">
                                <span class="text-base-content/50 max-w-[210mm] w-full text-sm mb-0.5">Vorlage:</span>
                                <img src="{{ asset('img/ckeditor_text.png') }}" alt="" class="max-w-[210mm] rounded-field">
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
                                        Weil es mit diesem Editor standardmäßig nicht möglich ist Elemente absolut zu positionieren, gibt es hierfür ebenfalls eine Vorlage, welche mit dem 
                                        <svg class="inline h-5! w-5! ck ck-icon ck-reset_all-excluded ck-icon_inherit-color ck-button__icon" viewBox="0 0 20 20" aria-hidden="true"><path d="M8 0H3a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h5a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2M2.5 2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 .5.5v15a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5zM13 0h5a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-5a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2m0 1.5a.5.5 0 0 0-.5.5v5a.5.5 0 0 0 .5.5h5a.5.5 0 0 0 .5-.5V2a.5.5 0 0 0-.5-.5zm0 8.5h5a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-5a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2m0 1.5a.5.5 0 0 0-.5.5v5a.5.5 0 0 0 .5.5h5a.5.5 0 0 0 .5-.5v-5a.5.5 0 0 0-.5-.5z" clip-rule="evenodd"></path></svg>
                                        Button hinzugefügt werden kann.<br/>
                                        Die Breite der Tabelle sollte voreingestellt auf 60% sein, während die beiden Spalten jeweils auf 65% und 35% eingestellt sind.
                                    </li>
                                    <li>
                                        Die Inhalte der beiden Spalten werden gleich formatiert. Der Header soll fettgeruckt und in der Größe "Klein" dargestellt werden, 
                                        während die unteren Werte in "Sehr klein" dargestellt werden.
                                    </li>
                                </ol>
                            </div>
                            <div class="w-full flex flex-col items-center justify-center bg-[#F7F7F7] rounded-field pt-1 pb-2">
                                <span class="text-base-content/50 max-w-[210mm] w-full text-sm mb-0.5">Vorlage:</span>
                                <img src="{{ asset('img/ckeditor_footer.png') }}" alt="" class="max-w-[210mm] rounded-field">
                            </div>
                            @break
                            {{-- Review and complete --}}
                            @case(5)
                            <div class="space-y-2 max-w-6xl mx-auto pb-6">
                                <span class="text-lg text-base-content/50 font-medium mb-2 block">Aufgabenstellung:</span>
                                Im letzen Schritt können sie das gesamte Layout nocheinmal überarbeiten um möglichst genau die Vorlage abzubilden. 
                                Bitte beachten Sie dass das final generierte PDF verglichen wird und dass der Editor eventuell nicht zu 100% mit dem PDF übereinstimmt.
                                Wenn Sie zufrieden mit ihrem Dokument sind drücken Sie einfach den "Weiter" Button um zum nächsten Editor zu kommen oder den Testlauf abzuschließen.
                            </div>
                            <div class="w-full flex flex-col items-center justify-center bg-[#F7F7F7] rounded-field pt-1 pb-2">
                                <span class="text-base-content/50 max-w-[210mm] w-full text-sm mb-0.5">Vorlage:</span>
                                <img src="{{ asset('img/ckeditor.png') }}" alt="" class="max-w-[210mm] rounded-field">
                            </div>
                            @break
                            @default
                        @endswitch
                    @endif
                </div>
            BLADE;
    }
}
