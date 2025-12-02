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
                                    Der aktuelle Editor bietet ein einfaches Interface an um grundlegende Dokumente zu erstellen. 
                                    Durch das simple Interface hat man jedoch auch nur eingeschränkt Kontrolle über die genaue Darstellung und Anordnung der Inhalte.
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
                                        Button drücken.<br/>
                                        Um die Variablen mit "echten" Werten anzuzeigen können Sie den
                                        <svg class="inline h-5! w-5! ck ck-icon ck-reset_all-excluded ck-icon_inherit-color ck-button__icon" viewBox="0 0 20 20" aria-hidden="true">
                                            <circle cx="9.00037" cy="9.79993" r="1.5"></circle>
                                            <path d="M5.75024 2.75005C5.75019 2.00005 5.75006 2.00005 5.75006 2.00005L5.74877 2.00005L5.74647 2.00006L5.73927 2.00009L5.71503 2.0003C5.6947 2.00053 5.66619 2.00098 5.63111 2.00185C5.56123 2.0036 5.46388 2.00707 5.35241 2.01402C5.14095 2.02722 4.83482 2.05536 4.56712 2.12276C4.1703 2.22267 3.82938 2.40399 3.55967 2.67392C3.29221 2.94161 3.1311 3.26001 3.03544 3.5803C2.85401 4.18776 2.8854 4.89393 2.92747 5.49256C2.9373 5.6324 2.94792 5.76849 2.95828 5.90131C2.99629 6.38849 3.03087 6.83163 3.01038 7.25369C2.98475 7.78147 2.87469 8.13279 2.6777 8.3656C2.45517 8.6286 2.1841 8.79405 1.95875 8.89436C1.84756 8.94386 1.75282 8.97509 1.68956 8.99319C1.65813 9.00219 1.63513 9.00776 1.62253 9.01062L1.61304 9.01269L1.00024 9.12173V9.75005H3.4023C3.54579 9.63123 3.68814 9.49364 3.82278 9.33451C4.33087 8.73405 4.47638 7.99036 4.50861 7.32643C4.5342 6.79933 4.48942 6.23163 4.4502 5.73429C4.44071 5.61404 4.43155 5.49785 4.42378 5.3874C4.38011 4.76596 4.37986 4.32043 4.4727 4.00956C4.51418 3.87069 4.56668 3.78828 4.62078 3.73414C4.67264 3.68223 4.76124 3.6207 4.93336 3.57736C5.06269 3.5448 5.25656 3.52293 5.44585 3.51111C5.53475 3.50556 5.61296 3.50277 5.66854 3.50139C5.6962 3.5007 5.71789 3.50036 5.73209 3.5002L5.74748 3.50007L5.75054 3.50005L6.5003 3.5L6.50019 2L5.75006 2.00005L5.75024 2.75005Z"></path>
                                            <path d="M5.75024 16.7501C5.75019 17.5001 5.75006 17.5001 5.75006 17.5001L5.74877 17.5001L5.74647 17.5001L5.73927 17.5L5.71503 17.4998C5.6947 17.4996 5.66619 17.4991 5.63111 17.4983C5.56123 17.4965 5.46388 17.493 5.35241 17.4861C5.14095 17.4729 4.83482 17.4448 4.56712 17.3774C4.1703 17.2774 3.82938 17.0961 3.55967 16.8262C3.29221 16.5585 3.1311 16.2401 3.03544 15.9198C2.85401 15.3124 2.8854 14.6062 2.92747 14.0076C2.9373 13.8677 2.94792 13.7316 2.95828 13.5988C2.99629 13.1116 3.03087 12.6685 3.01038 12.2464C2.98475 11.7186 2.87469 11.3673 2.6777 11.1345C2.45517 10.8715 2.1841 10.7061 1.95875 10.6058C1.84756 10.5563 1.75282 10.525 1.68956 10.5069C1.65813 10.4979 1.63513 10.4924 1.62253 10.4895L1.61304 10.4874L1.00024 10.3784V9.75005H3.4023C3.54579 9.86887 3.68814 10.0065 3.82278 10.1656C4.33087 10.7661 4.47638 11.5098 4.50861 12.1737C4.5342 12.7008 4.48942 13.2685 4.4502 13.7658C4.44071 13.8861 4.43155 14.0023 4.42378 14.1127C4.38011 14.7341 4.37986 15.1797 4.4727 15.4906C4.51418 15.6294 4.56668 15.7118 4.62078 15.766C4.67264 15.8179 4.76124 15.8794 4.93336 15.9228C5.06269 15.9553 5.25656 15.9772 5.44585 15.989C5.53475 15.9945 5.61296 15.9973 5.66854 15.9987C5.6962 15.9994 5.71789 15.9998 5.73209 15.9999L5.74748 16L5.75054 16.0001L6.5003 16.0001L6.50019 17.5001L5.75006 17.5001L5.75024 16.7501Z"></path>
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12.2514 2.00005L12.2501 2.00005L11.5 2L11.4999 3.5L12.2496 3.50005L12.2527 3.50007L12.2681 3.5002C12.2823 3.50036 12.304 3.5007 12.3316 3.50139C12.3872 3.50277 12.4654 3.50556 12.5543 3.51111C12.7436 3.52293 12.9375 3.5448 13.0668 3.57736C13.2389 3.6207 13.3275 3.68223 13.3794 3.73414C13.4335 3.78828 13.486 3.87069 13.5275 4.00956C13.6203 4.32043 13.6201 4.76596 13.5764 5.3874C13.5686 5.49785 13.5595 5.61404 13.55 5.73429C13.5108 6.23163 13.466 6.79933 13.4916 7.32643C13.5238 7.99036 13.6693 8.73405 14.1774 9.33451C14.312 9.49364 14.4544 9.63123 14.5979 9.75005C14.4544 9.86887 14.312 10.0065 14.1774 10.1656C13.7121 10.7154 13.5509 11.3854 13.5023 12.0042C13.6011 12.0012 13.7003 11.9997 13.7999 11.9997C14.208 11.9997 14.6093 12.0247 15.0018 12.0729C15.0416 11.6402 15.1479 11.3408 15.3225 11.1345C15.545 10.8715 15.8161 10.7061 16.0414 10.6058C16.1526 10.5563 16.2474 10.525 16.3106 10.5069C16.342 10.4979 16.365 10.4924 16.3776 10.4895L16.3871 10.4874L16.9999 10.3784V9.75005V9.12173L16.3871 9.01269L16.3776 9.01062C16.365 9.00776 16.342 9.00219 16.3106 8.99319C16.2474 8.97509 16.1526 8.94386 16.0414 8.89436C15.8161 8.79405 15.545 8.6286 15.3225 8.3656C15.1255 8.13279 15.0154 7.78147 14.9898 7.25369C14.9693 6.83163 15.0039 6.38849 15.0419 5.90131C15.0523 5.76849 15.0629 5.6324 15.0727 5.49256C15.1148 4.89393 15.1462 4.18776 14.9647 3.5803C14.8691 3.26001 14.708 2.94161 14.4405 2.67392C14.1708 2.40399 13.8299 2.22267 13.433 2.12276C13.1654 2.05536 12.8592 2.02722 12.6478 2.01402C12.5363 2.00707 12.4389 2.0036 12.3691 2.00185C12.334 2.00098 12.3055 2.00053 12.2851 2.0003L12.2609 2.00009L12.2537 2.00006L12.2514 2.00005Z"></path>
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M9.00335 17.2062L9.00308 17.2065C8.7234 17.5118 8.24919 17.5327 7.94372 17.2532C7.63816 16.9735 7.61716 16.4991 7.89681 16.1935L8.45008 16.6999C7.89681 16.1935 7.89697 16.1934 7.89713 16.1932L7.89751 16.1928L7.89844 16.1918L7.90098 16.189L7.90879 16.1806L7.93517 16.1526C7.95746 16.1292 7.98914 16.0963 8.02971 16.0555C8.11079 15.9738 8.22768 15.8597 8.37644 15.724C8.6732 15.4532 9.10079 15.0927 9.62744 14.7314C10.6647 14.0198 12.1659 13.2499 13.8501 13.2499C15.5343 13.2499 17.0355 14.0198 18.0727 14.7314C18.5994 15.0927 19.027 15.4532 19.3237 15.724C19.4725 15.8597 19.5894 15.9738 19.6705 16.0555C19.711 16.0963 19.7427 16.1292 19.765 16.1526L19.7914 16.1806L19.7992 16.189L19.8017 16.1918L19.8027 16.1928L19.803 16.1932C19.8032 16.1934 19.8034 16.1935 19.2501 16.6999L19.8034 16.1935C20.083 16.4991 20.062 16.9735 19.7565 17.2532C19.4511 17.5326 18.9772 17.5118 18.6975 17.207L18.6971 17.2065L18.6968 17.2062L18.6945 17.2037L18.6783 17.1865C18.6629 17.1704 18.6386 17.1452 18.6059 17.1123C18.5404 17.0463 18.4414 16.9494 18.3127 16.8321C18.0546 16.5966 17.6814 16.282 17.2242 15.9683C16.9805 15.8012 16.7185 15.6381 16.4421 15.4883C16.7016 15.9322 16.8502 16.4487 16.8502 16.9999C16.8502 18.6567 15.5071 19.9999 13.8502 19.9999C12.1934 19.9999 10.8502 18.6567 10.8502 16.9999C10.8502 16.4486 10.9989 15.932 11.2584 15.4881C10.9819 15.6379 10.7198 15.8011 10.476 15.9683C10.0188 16.282 9.64555 16.5966 9.38746 16.8321C9.25879 16.9494 9.15975 17.0463 9.09425 17.1123C9.06153 17.1452 9.03726 17.1704 9.02192 17.1865L9.00572 17.2037L9.00335 17.2062Z"></path>
                                            <circle cx="14.8253" cy="16.1749" r="1.125" fill="white"></circle>
                                        </svg>
                                        Button drücken und "Standardwerte" auswählen.
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
                                <img src="{{ asset('img/grapesjs_header.png') }}" alt="" class="max-w-[210mm] rounded-field">
                            </div>
                            @break
                            @default
                        @endswitch
                    @endif
                </div>
            BLADE;
    }
}
