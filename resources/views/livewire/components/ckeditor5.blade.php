@props(['name' => 'field', 'value' => '', 'margins'])

<div wire:ignore class="w-full flex flex-col items-center justify-start">
    <div class="w-full border-(length:--border) border-neutral bg-base-200 rounded-field mb-1">
        {{-- Menubar injection point -> will be filled --}}
        <div id="ckeditor_menubar_{{ $name }}" class="w-full"></div>
        {{-- Toolbar injection point -> will be filled --}}
        <div id="ckeditor_toolbar_{{ $name }}" class="w-full mb-1"></div>
    </div>
    {{-- Editor background --}}
    <div class="w-full border-(length:--border) border-neutral rounded-field mx-auto bg-base-200 py-2"
        style="font-size: 12pt">
        {{-- Editor injection point -> will be hidden and the editable box will be appended below --}}
        <div class="min-w-[21cm] min-h-[29.7cm] max-w-[21cm] max-h-[29.7cm] mx-auto bg-white"
            id="ckeditor_{{ $name }}">
            {!! $this->ckeditorContent !!}
        </div>
    </div>
</div>

@assets
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/47.2.0/ckeditor5.css" />
    <script src="https://cdn.ckeditor.com/ckeditor5/47.2.0/ckeditor5.umd.js"></script>
    <link rel="stylesheet"
        href="https://cdn.ckeditor.com/ckeditor5-premium-features/47.2.0/ckeditor5-premium-features.css" />
    <script src="https://cdn.ckeditor.com/ckeditor5-premium-features/47.2.0/ckeditor5-premium-features.umd.js"></script>
@endassets

@script
    <script>
        window.ckeditor = null;
        let inputDelay;

        document.addEventListener('livewire:navigated', () => {
            const {
                DecoupledEditor,
                Alignment,
                AccessibilityHelp,
                Autoformat,
                AutoImage,
                Autosave,
                BlockQuote,
                Bold,
                CloudServices,
                Essentials,
                Mention,
                Heading,
                FontFamily,
                FontSize,
                FontColor,
                FontBackgroundColor,
                ImageBlock,
                ImageCaption,
                ImageInline,
                ImageInsert,
                ImageInsertViaUrl,
                ImageResize,
                ImageStyle,
                ImageTextAlternative,
                ImageToolbar,
                ImageUpload,
                Indent,
                IndentBlock,
                Italic,
                Link,
                LinkImage,
                List,
                ListProperties,
                MediaEmbed,
                Paragraph,
                PasteFromOffice,
                PictureEditing,
                SelectAll,
                Table,
                TableLayout,
                TableCaption,
                TableCellProperties,
                TableColumnResize,
                TableProperties,
                TableToolbar,
                TextTransformation,
                TodoList,
                Underline,
                Strikethrough,
                Superscript,
                Subscript,
                Undo,
                Base64UploadAdapter,
            } = CKEDITOR;
            const {
                ExportPdf,
                MergeFields
            } = CKEDITOR_PREMIUM_FEATURES;

            DecoupledEditor
                .create(document.querySelector('#ckeditor_{{ $name }}'), {
                    licenseKey: '{{ config('ckeditor5.presets.default.licenseKey') }}',
                    menuBar: {
                        isVisible: true,
                    },
                    toolbar: [
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
                        {
                            label: 'Text Style',
                            items: [
                                'strikethrough',
                                'superscript',
                                'subscript'
                            ],
                        },
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
                    language: 'de',
                    plugins: [
                        Alignment,
                        AccessibilityHelp,
                        Autoformat,
                        AutoImage,
                        Autosave,
                        BlockQuote,
                        Bold,
                        CloudServices,
                        Essentials,
                        ExportPdf,
                        Mention,
                        MergeFields,
                        Heading,
                        FontFamily,
                        FontSize,
                        FontColor,
                        FontBackgroundColor,
                        ImageBlock,
                        ImageCaption,
                        ImageInline,
                        ImageInsert,
                        ImageInsertViaUrl,
                        ImageResize,
                        ImageStyle,
                        ImageTextAlternative,
                        ImageToolbar,
                        ImageUpload,
                        Indent,
                        IndentBlock,
                        Italic,
                        Link,
                        LinkImage,
                        List,
                        ListProperties,
                        MediaEmbed,
                        Paragraph,
                        PasteFromOffice,
                        PictureEditing,
                        SelectAll,
                        Table,
                        TableLayout,
                        TableCaption,
                        TableCellProperties,
                        TableColumnResize,
                        TableProperties,
                        TableToolbar,
                        TextTransformation,
                        TodoList,
                        Underline,
                        Strikethrough,
                        Superscript,
                        Subscript,
                        Undo,
                        Base64UploadAdapter,
                    ],
                    table: {
                        contentToolbar: [
                            'tableColumn',
                            'tableRow',
                            'mergeTableCells',
                            'tableProperties',
                            'tableCellProperties',
                            'toggleTableCaption',
                        ],
                    },
                    image: {
                        toolbar: [
                            'imageTextAlternative',
                            'imageStyle',
                            'imageResize',
                            'imageInsertViaUrl',
                        ],
                    },
                    mergeFields: {
                        definitions: [{
                                id: 'guestName',
                                label: 'Guest name', // Optional.
                                defaultValue: 'Guest', // Optional.
                            },
                            {
                                groupId: 'large',
                                groupLabel: 'Große Platzhalter',
                                definitions: [{
                                        id: 'guestSpecialOffersBox',
                                        label: 'Special offers', // Optional.
                                        type: 'block', // Optional.
                                        height: 150, // Optional.
                                    },
                                    {
                                        id: 'companyLogo',
                                        label: 'Company logo', // Optional.
                                        type: 'image', // Optional.
                                        width: 300, // Optional.
                                        height: 300, // Optional.
                                    },
                                ],
                            },
                        ],
                    },
                })
                .then(editor => {
                    window.ckeditor = editor;
                    // Initialize the toolbar to our custom element
                    document.querySelector('#ckeditor_toolbar_{{ $name }}').appendChild(
                        editor.ui.view.toolbar.element
                    );
                    // Initialize the menubar to our custom element
                    document.querySelector('#ckeditor_menubar_{{ $name }}').appendChild(editor.ui.view
                        .menuBarView.element);
                    // Update content on change
                    editor.model.document.on('change:data', () => {
                        clearTimeout(inputDelay);
                        inputDelay = setTimeout(() => $wire.set('ckeditorContent', editor.getData()),
                            1000);
                    });
                })
                .catch(e => console.error(e));
        });

        document.addEventListener('livewire:navigate', () => {
            console.log("Destroying editor:");
            console.log(window.ckeditor);
            window.ckeditor?.destroy().then(() => {
                clearTimeout(inputDelay);
                window.ckeditor = undefined;
                console.log("Destroyed editor:");
                console.log(window.ckeditor);
            }).catch(error => {
                console.error(error);
            });

        });
    </script>
@endscript
