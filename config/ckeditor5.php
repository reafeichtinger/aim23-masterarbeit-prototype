<?php

// You can place your custom package configuration in here.
return [
    'presets' => [
        'default' => [
            'licenseKey' => env('CKEDITOR_LICENSE_KEY'),
            'tokenUrl' => env('CKEDITOR_TOKEN_URL'),
            'authorization' => env('CKEDITOR_AUTHORIZATION'),
            'environment' => env('CKEDITOR_ENVIRONMENT'),
            'editorType' => 'classic',
            'cloud' => [
                'editorVersion' => env('CKEDITOR_VERSION', '47.2.0'),
                'premium' => (bool) env('CKEDITOR_PREMIUM', false),
                'translations' => ['de'],
            ],
            'config' => [
                'menuBar' => [
                    'isVisible' => true,
                ],
                'toolbar' => [
                    'items' => [
                        'exportPdf',
                        'insertMergeField',
                        'previewMergeFields',
                        'undo',
                        'redo',
                        '|',
                        'heading',
                        '|',
                        'fontFamily',
                        'fontSize',
                        'fontColor',
                        'fontBackgroundColor',
                        'alignment',
                        '|',
                        'bold',
                        'italic',
                        'underline',
                        [
                            'label' => 'Text Style',
                            'items' => ['strikethrough', 'superscript', 'subscript'],
                        ],
                        '|',
                        'link',
                        'insertImage',
                        'insertTable',
                        'insertTableLayout',
                        'blockQuote',
                        'mediaEmbed',
                        '|',
                        'bulletedList',
                        'numberedList',
                        'todoList',
                        'outdent',
                        'indent',
                    ],
                ],
                'language' => 'de',
                'plugins' => [
                    'Alignment',
                    'AccessibilityHelp',
                    'Autoformat',
                    'AutoImage',
                    'Autosave',
                    'BlockQuote',
                    'Bold',
                    'CloudServices',
                    'Essentials',
                    'ExportPdf',
                    'Mention',
                    'MergeFields',
                    'Heading',
                    'FontFamily',
                    'FontSize',
                    'FontColor',
                    'FontBackgroundColor',
                    'ImageBlock',
                    'ImageCaption',
                    'ImageInline',
                    'ImageInsert',
                    'ImageInsertViaUrl',
                    'ImageResize',
                    'ImageStyle',
                    'ImageTextAlternative',
                    'ImageToolbar',
                    'ImageUpload',
                    'Indent',
                    'IndentBlock',
                    'Italic',
                    'Link',
                    'LinkImage',
                    'List',
                    'ListProperties',
                    'MediaEmbed',
                    'Paragraph',
                    'PasteFromOffice',
                    'PictureEditing',
                    'SelectAll',
                    'Table',
                    'TableLayout',
                    'TableCaption',
                    'TableCellProperties',
                    'TableColumnResize',
                    'TableProperties',
                    'TableToolbar',
                    'TextTransformation',
                    'TodoList',
                    'Underline',
                    'Strikethrough',
                    'Superscript',
                    'Subscript',
                    'Undo',
                    'Base64UploadAdapter',
                ],
                'table' => [
                    'contentToolbar' => [
                        'tableColumn',
                        'tableRow',
                        'mergeTableCells',
                        'tableProperties',
                        'tableCellProperties',
                        'toggleTableCaption',
                    ],
                ],
                'image' => [
                    'toolbar' => [
                        'imageTextAlternative',
                        'imageStyle',
                        'imageResize',
                        'imageInsertViaUrl',
                    ],
                ],
                'mergeFields' => [
                    'definitions' => [
                        [
                            'id' => 'guestName',
                            'label' => 'Guest name', // Optional.
                            'defaultValue' => 'Guest', // Optional.
                        ],
                        [
                            'groupId' => 'large',
                            'groupLabel' => 'Große Platzhalter',
                            'definitions' => [
                                [
                                    'id' => 'guestSpecialOffersBox',
                                    'label' => 'Special offers', // Optional.
                                    'type' => 'block', // Optional.
                                    'height' => 150, // Optional.
                                ],
                                [
                                    'id' => 'companyLogo',
                                    'label' => 'Company logo', // Optional.
                                    'type' => 'image', // Optional.
                                    'width' => 300, // Optional.
                                    'height' => 300, // Optional.
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'contexts' => [
        'default' => [
            'config' => [
                'plugins' => [],
            ],
        ],
    ],
];
