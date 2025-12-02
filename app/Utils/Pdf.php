<?php

namespace App\Utils;

use App\Enums\EditorEnum;
use Gotenberg\Gotenberg;
use Gotenberg\Stream;
use Psr\Http\Message\ResponseInterface;

class Pdf
{
    public static function getPdfAsResponse(string $html, array $data = [], ?EditorEnum $editor = null): ResponseInterface
    {
        $html = static::renderDocument(static::replaceVariables($html, $data), $editor);

        return Gotenberg::send(
            Gotenberg::chromium(config('gotenberg.gotenberg_api_url'))
                ->pdf()
                ->paperSize(8.27, 11.7) // A4 Format
                ->margins(top: '2cm', right: '2cm', bottom: '2cm', left: '2cm')
                ->assets(Stream::string('style.css', file_get_contents(resource_path('css/ckeditor-pdf.css'))))
                ->html(Stream::string('index.html', $html))
        );
    }

    public static function replaceVariables(string $html, array $data = []): string
    {
        return preg_replace_callback('/{{\s*(.*?)\s*}}/', function ($matches) use ($data) {
            return $data[$matches[1]] ?? $matches[0]; // replace if exists, otherwise leave as-is
        }, $html);
    }

    public static function renderDocument(string $html, ?EditorEnum $editor = null): string
    {
        return view(
            match ($editor) {
                EditorEnum::GRAPESJS => 'grapesjs-pdf',
                EditorEnum::CKEDITOR => 'ckeditor-pdf',
                default => 'ckeditor-pdf',
            },
            ['content' => $html, 'css' => file_get_contents(resource_path('css/ckeditor-pdf.css'))]
        )->render();
    }
}
