<div x-data="grapesjsComponent({
    wire: $wire,
    name: @js($name),
    initialContent: @js($grapesjsContent),
})" x-on:livewire:navigate.window="destroy()" wire:ignore>
    <div id="grapesjs_{{ $name }}" class="min-h-[80vh]"></div>
</div>

@script
    <script>
        window.grapesjsComponent = function({
            wire,
            name,
            initialContent
        }) {
            return {
                editor: null,
                inputDelay: null,

                async init() {
                    const root = document.getElementById('grapesjs_' + name);
                    if (!root) return;

                    // Clean old instance (shouldn't happen but for safety)
                    if (this.editor) {
                        this.editor.destroy();
                        this.editor = null;
                    }

                    this.editor = await createStudioEditor({
                        root,
                        theme: 'light',
                        plugins: [window.presetPrintable, window.canvasFullSize],

                        project: {
                            type: 'document',
                            default: {
                                pages: [{
                                    name: 'Page',
                                    component: ''
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
                                        type: 'canvasSidebarTop'
                                    },
                                    {
                                        type: 'sidebarRight'
                                    }
                                ]
                            }
                        },

                        storage: {
                            type: 'self',
                            autosaveChanges: 1,

                            onSave: ({
                                editor
                            }) => {
                                clearTimeout(this.inputDelay);
                                this.inputDelay = setTimeout(() => {
                                    wire.set('grapesjsContent', JSON.stringify(
                                        editor.getProjectData()
                                    ));
                                }, 400);
                            },

                            onLoad: () => {
                                return {
                                    project: initialContent ?
                                        JSON.parse(initialContent) : {}
                                };
                            }
                        }
                    });
                },

                destroy() {
                    clearTimeout(this.inputDelay);

                    if (this.editor) {
                        wire.set(
                            'grapesjsContent',
                            JSON.stringify(this.editor.getProjectData())
                        );
                        this.editor.destroy();
                        this.editor = null;
                    }
                }
            };
        }
    </script>
@endscript
