@props(['name' => 'field', 'value' => '', 'margins'])

<div {{ $attributes->merge(['class' => '']) }} x-data x-init="initCkeditor('{{ $name }}', $dispatch)">
    <div wire:ignore class="w-full flex flex-col items-center justify-start">
        {{-- Toolbar injection point -> will be filled --}}
        <div id="ckeditor_toolbar_{{ $name }}" class="max-w-full"></div>
        <div class="w-full bg-base-200 flex flex-row justify-center rounded-b-field lg:border-[length:var(--border)] lg:border-neutral lg:p-2"
            style="font-size: 12pt">
            <div style="width: 100%; max-width: 21cm; min-height: 29.7cm">
                {{-- Editor injection point -> will be hidden and the editor will be appended below --}}
                <div id="ckeditor_{{ $name }}" class="w-full h-full p-8 flex flex-row justify-center">
                    <x-loading class="progress-primary h-10 w-10" />
                </div>
            </div>
        </div>
    </div>
    {{-- This will set the margins of the editor --}}
    <style>
        :root {
            --ck-document-margin-top: {{ $margins['top'] ?? '1in' }};
            --ck-document-margin-bottom: {{ $margins['bottom'] ?? '1in' }};
            --ck-document-margin-left: {{ $margins['left'] ?? '1in' }};
            --ck-document-margin-right: {{ $margins['right'] ?? '1in' }};
        }
    </style>
</div>

@pushonce('scripts')
    <script src="{{ asset('js/ckeditor/ckeditor.js') }}" referrerpolicy="origin"></script>
    <script src="{{ asset('js/ckeditor/translations/de.js') }}" referrerpolicy="origin"></script>

    <script>
        function initCkeditor(name, $dispatch) {
            var ckeditor = CKSource.Editor
                .create(document.querySelector('#ckeditor_' + name), {
                    language: 'de',
                    toolbar: {
                        shouldNotGroupWhenFull: window.innerWidth > 1023 ? true : false, // Group on mobile
                    },
                })
                .then(editor => {
                    // The toolbar needs to be explicitly appended.
                    document.querySelector('#ckeditor_toolbar_' + name).appendChild(editor.ui.view.toolbar.element);
                    window.editor = editor;

                    // Set initial data
                    editor.setData({!! json_encode($value) !!});

                    // When visible content changes
                    editor.model.document.on('change:data', (eventInfo, batch) => {
                        $dispatch('input', editor.getData());
                    });

                    // With this event you can update the html content of the editor
                    document.addEventListener('update-ckeditor-content', function(event) {
                        editor.setData(event.detail);
                    });
                })
                .catch(error => {
                    console.error('There was a problem initializing the editor.', error);
                });
        }
    </script>
@endpushonce
