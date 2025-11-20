<?php

namespace App\Enums;

use Rea\LaravelEnumsPlus\EnumPlus;
use Rea\LaravelEnumsPlus\IsEnumPlus;

enum EditorEnum: string implements EnumPlus
{
    use IsEnumPlus;

    case CKEDITOR = 'ckeditor';
    case GRAPESJS = 'grapesjs';

    #region EnumPlus

    public function translations(): array
    {
        return [
            'de' => [
                self::CKEDITOR->value => 'CKEditor 5',
                self::GRAPESJS->value => 'GrapesJS',
            ],
        ];
    }

    public function withMeta(): array
    {
        return match ($this) {
            self::CKEDITOR => ['number' => self::CKEDITOR->toNumber()],
            self::GRAPESJS => ['number' => self::GRAPESJS->toNumber()],
        };
    }

    #endregion EnumPlus
    #region Helpers

    public function toNumber(): int
    {
        return match ($this) {
            self::CKEDITOR => 1,
            self::GRAPESJS => 2,
        };
    }

    public function defaultContent(): string|array
    {
        return match ($this) {
            self::CKEDITOR => '',
            self::GRAPESJS => [],
        };
    }

    #endregion Helpers
}
