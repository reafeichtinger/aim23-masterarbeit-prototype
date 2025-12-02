<div wire:ignore class="w-full flex flex-col items-center justify-start">
    <div
        class="w-full border-(length:--border) border-neutral bg-base-200 rounded-field mb-1 min-h-19 flex flex-col place-content-center">
        {{-- Menubar injection point -> will be filled --}}
        <div id="ckeditor_menubar_{{ $name }}" class="w-full"></div>
        {{-- Toolbar injection point -> will be filled --}}
        <div id="ckeditor_toolbar_{{ $name }}" class="w-full mb-1"></div>
        {{-- Loading spinner - will be removed when toolbar is initialized --}}
        <x-loading class="text-primary self-center place-self-center" />
    </div>
    {{-- Editor background --}}
    <div class="relative w-full border-(length:--border) border-neutral rounded-field mx-auto bg-base-200 py-2"
        style="font-size: 12pt">
        {{-- Editor injection point -> will be hidden and the editable box will be appended below --}}
        <div class="h-[297mm] w-[210mm] mx-auto bg-white" id="ckeditor_{{ $name }}">
            {!! $this->ckeditorContent !!}
        </div>
        {{-- Print pdf button --}}
        <x-button class="absolute top-2 right-2 btn-ghost btn-square" wire:click="print" icon="o-printer" spinner
            tooltip-left="PDF Datei generieren" />
    </div>
</div>

@assets
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/47.2.0/ckeditor5.css" />
    <script src="https://cdn.ckeditor.com/ckeditor5/47.2.0/ckeditor5.umd.js"></script>
    <link rel="stylesheet"
        href="https://cdn.ckeditor.com/ckeditor5-premium-features/47.2.0/ckeditor5-premium-features.css" />
    <script src="https://cdn.ckeditor.com/ckeditor5-premium-features/47.2.0/ckeditor5-premium-features.umd.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/47.2.0/translations/de.umd.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5-premium-features/47.2.0/translations/de.umd.js"></script>
@endassets

@script
    <script>
        window.ckeditor = null;
        let inputDelay;

        document.addEventListener('livewire:navigated', () => {
            const {
                AccessibilityHelp,
                Alignment,
                Autoformat,
                AutoImage,
                Autosave,
                Base64UploadAdapter,
                BlockQuote,
                Bold,
                CloudServices,
                DecoupledEditor,
                Essentials,
                FontBackgroundColor,
                FontColor,
                FontFamily,
                FontSize,
                Heading,
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
                Mention,
                Paragraph,
                PasteFromOffice,
                PictureEditing,
                SelectAll,
                Strikethrough,
                Subscript,
                Superscript,
                Table,
                TableCaption,
                TableCellProperties,
                TableColumnResize,
                TableLayout,
                TableProperties,
                TableToolbar,
                TextTransformation,
                TodoList,
                Underline,
                Undo,
            } = CKEDITOR;
            const {
                ExportPdf,
                MergeFields,
                Template
            } = CKEDITOR_PREMIUM_FEATURES;

            DecoupledEditor
                .create(document.querySelector('#ckeditor_{{ $name }}'), {
                    licenseKey: '{{ config('ckeditor5.presets.default.licenseKey') }}',
                    language: {
                        ui: 'de',
                        content: 'de'
                    },
                    menuBar: {
                        isVisible: true,
                        removeItems: ['menuBar:exportPdf'],
                    },
                    toolbar: [
                        'insertTemplate',
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
                        AccessibilityHelp,
                        Alignment,
                        Autoformat,
                        AutoImage,
                        Autosave,
                        Base64UploadAdapter,
                        BlockQuote,
                        Bold,
                        CloudServices,
                        Essentials,
                        ExportPdf,
                        FontBackgroundColor,
                        FontColor,
                        FontFamily,
                        FontSize,
                        Heading,
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
                        Mention,
                        MergeFields,
                        Paragraph,
                        PasteFromOffice,
                        PictureEditing,
                        SelectAll,
                        Strikethrough,
                        Subscript,
                        Superscript,
                        Table,
                        TableCaption,
                        TableCellProperties,
                        TableColumnResize,
                        TableLayout,
                        TableProperties,
                        TableToolbar,
                        Template,
                        TextTransformation,
                        TodoList,
                        Underline,
                        Undo,
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
                    exportPdf: {
                        tokenUrl: '{{ config('ckeditor5.presets.default.tokenUrl') }}',
                    },
                    template: {
                        definitions: [{
                            title: 'Firmenlogo',
                            description: 'Das Logo der Venuzle GmbH',
                            icon: @js($this->getVenuzleLogo()),
                            data: @js($this->getVenuzleLogo(true)),
                        }, ],
                    },
                    mergeFields: @js($this->getMergeFields()),
                })
                .then(editor => {
                    window.ckeditor = editor;
                    // Initialize the toolbar to our custom element
                    document.querySelector('#ckeditor_toolbar_{{ $name }}').appendChild(
                        editor.ui.view.toolbar.element
                    );
                    // Initialize the menubar to our custom element
                    document.querySelector('#ckeditor_menubar_{{ $name }}').appendChild(editor.ui
                        .view
                        .menuBarView.element);
                    // Update content on change
                    editor.model.document.on('change:data', () => {
                        clearTimeout(inputDelay);
                        inputDelay = setTimeout(() => $wire.set('ckeditorContent', editor
                                .getData()),
                            1000);
                    });
                    // Remove loading spinner
                    document.querySelector(
                        'span.loading.text-primary.self-center.place-self-center').remove();

                    {{ $this->debug ? 'CKEditorInspector.attach(editor);' : '' }}
                })
                .catch(e => console.error(e));
        }, {
            once: true
        });

        // Clean up editor instance and timeouts when navigating away
        document.addEventListener('livewire:navigate', () => {
            // Make sure final data is saved before destroying and clear timeout
            clearTimeout(inputDelay);
            $wire.set('ckeditorContent', window.ckeditor.getData());

            // Destroy the editor instance
            window.ckeditor?.destroy().then(() => {
                window.ckeditor = undefined;
            }).catch(error => {
                console.error(error);
            });
        }, {
            once: true
        });
    </script>
@endscript

@assets
    {{-- This will set the margins of the editor --}}
    <style>
        div[contenteditable="true"] {
            padding-top: {{ $margins['top'] ?? '2cm' }} !important;
            padding-bottom: {{ $margins['bottom'] ?? '2cm' }} !important;
            padding-left: {{ $margins['left'] ?? '2cm' }} !important;
            padding-right: {{ $margins['right'] ?? '2cm' }} !important;
        }
    </style>
@endassets
