<?php

namespace App\Utils;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class DocumentVariables
{
    private static array $variables = [
        'operator' => [
            'name' => 'Venuzle GmbH',
            'address' => 'Musterstraße 6, 27550 Musterstadt',
            'phone' => '+43 000 000 0000',
            'fax' => '+43 000 000 0000',
            'email' => 'hallo@venuzle.at',
            'iban' => 'AT00 0000 0000 0000 0000',
            'bic' => 'FABAATGR',
        ],
        'recipient' => [
            'id' => '5034',
            'name' => 'Kim Mustermensch',
            'address' => [
                'street' => 'Lange Straße 42',
                'city' => '25928 Erste Stadt',
            ],
        ],
        'invoice' => [
            'id' => 'R2304-25',
            'date' => '02.12.2025',
            'dueDate' => '16.12.2025',
            'positions' => [
                [
                    'id' => '12345',
                    'name' => 'Klopapier',
                    'amount' => '2',
                    'price' => '4,99',
                    'sum' => '9.98',
                ], [
                    'id' => '23456',
                    'name' => 'Seife',
                    'amount' => '1',
                    'price' => '3,99',
                    'sum' => '3.99',
                ], [
                    'id' => '45678',
                    'name' => 'Teelichter (20 St.)',
                    'amount' => '2',
                    'price' => '5,99',
                    'sum' => '11.98',
                ], ],
            'sum' => '25,95',
            'vat' => '4,33',
        ],
    ];

    public static function forCKEditorPrint(): array
    {
        return Collection::make(static::forCKEditor())
            ->pluck('definitions')
            ->flatten(1)
            ->filter(fn ($item) => isset($item['id'], $item['defaultValue']))
            ->pluck('defaultValue', 'id')
            ->toArray();
    }

    public static function forCKEditor(): array
    {
        $result = [];
        $variables = Collection::make(static::$variables);

        foreach ($variables as $group => $data) {

            $definitions = [];
            foreach ($data as $key => $values) {

                // Add special field for table instead of positions
                if ("$group-$key" == 'invoice-positions') {
                    $definitions[] = [
                        'id' => 'invoice-table',
                        'label' => trans('variables.invoice-table'),
                        'type' => 'block',
                        'height' => 93,
                        'defaultValue' => view('documents.ckeditor.ckeditor-table')->render(),
                    ];

                    continue;
                }

                $values = Arr::wrap($values);
                foreach ($values as $index => $value) {
                    $id = "$group-$key" . (is_int($index) ? '' : "-$index");
                    $definitions[] = [
                        'id' => $id,
                        'label' => trans("variables.$id"),
                        'defaultValue' => $value,
                    ];

                }

            }

            $result[] = [
                'groupId' => $group,
                'groupLabel' => trans("variables.$group"),
                'definitions' => $definitions,
            ];
        }

        return $result;
    }
}
