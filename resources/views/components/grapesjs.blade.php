@props(['name' => 'field', 'value' => '', 'margins'])

<div {{ $attributes->merge(['class' => 'min-h-[80vh]']) }} id="grapesjs_{{ $name }}">
</div>

@script
    <script>
        document.addEventListener('livewire:initialized', () => {
            var grapesjs = createStudioEditor({
                root: '#grapesjs_{{ $name }}',
                theme: 'light',
                plugins: [
                    window.presetPrintable,
                    window.canvasFullSize,
                ],
                project: {
                    type: 'document',
                    default: {
                        pages: [{
                            name: 'Invoice',
                            component: '',
                        }]
                    }
                },
                layout: {
                    default: {
                        type: 'row',
                        height: '100%',
                        children: [{
                                type: 'sidebarLeft',
                                children: {
                                    type: 'panelLayers',
                                    header: {
                                        label: 'Layers',
                                        collapsible: false,
                                        icon: 'layers'
                                    }
                                }
                            },
                            {
                                type: 'canvasSidebarTop',
                                sidebarTop: {
                                    rightContainer: {
                                        buttons: ({
                                            items
                                        }) => [{
                                                id: 'print',
                                                icon: '<svg viewBox="0 0 24 24"><path d="M18 3H6v4h12m1 5a1 1 0 0 1-1-1 1 1 0 0 1 1-1 1 1 0 0 1 1 1 1 1 0 0 1-1 1m-3 7H8v-5h8m3-6H5a3 3 0 0 0-3 3v6h4v4h12v-4h4v-6a3 3 0 0 0-3-3Z"/></svg>',
                                                onClick: ({
                                                    editor
                                                }) => editor.runCommand('presetPrintable:print')
                                            },
                                            ...items.filter(item => !['showImportCode',
                                                    'fullscreen'
                                                ]
                                                .includes(item.id))
                                        ]
                                    }
                                }
                            },
                            {
                                type: 'sidebarRight'
                            }
                        ]
                    }
                },
            });
        })
    </script>
@endscript
