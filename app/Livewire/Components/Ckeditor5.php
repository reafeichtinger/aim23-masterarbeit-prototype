<?php

namespace App\Livewire\Components;

use App\Utils\DocumentVariables;
use App\Utils\GotenbergApi;
use Illuminate\Support\Facades\Blade;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class Ckeditor5 extends Component
{
    /**
     * The content of the CKEditor5 instance.
     * This property is bound to Livewire and will trigger updates when changed.
     * Made public so Livewire can serialize and bind it to the frontend.
     *
     * @var array<string, string> Content sections, e.g., ['main' => '<p>Initial content</p>']
     */
    #[Modelable]
    public mixed $ckeditorContent = null;

    public string $name = 'field';
    public bool $debug = false;
    public array $margins = [];

    public function mount(?string $name = null, array $margins = [], bool $debug = false): void
    {
        $this->name = $name;
        $this->margins = $margins;
        $this->debug = $debug;
    }

    public function print(): mixed
    {
        $html = Blade::render(<<<'HTML'
            <!DOCTYPE html>
            <html lang="de">
                
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Vorschau</title>

                <style>
                    {!! $styles !!}
                </style>
            </head>
            <body>
                {!! $content !!}
            </body>
            </html>
            HTML, ['content' => $this->ckeditorContent, 'styles' => file_get_contents(resource_path('css/ckeditor-pdf.css'))]);

        $response = GotenbergApi::getPdf($html, DocumentVariables::forCKEditorPrint());

        return response()->streamDownload(function () use ($response) {
            echo $response->getBody();
        }, 'Vorschau.pdf', [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="Vorschau.pdf"',
        ]);
    }

    public function getMergeFields(): array
    {
        return DocumentVariables::forCKEditor();
    }

    public function getVenuzleLogo(bool $base64 = false): string
    {
        return $base64 ?
            '<figure class="image"><img style="width:100%; height: auto;" src="data:image/png;base64,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"></figure>' :
            Blade::render('<x-venuzle-logo />');
    }
}
