<div x-data="grapesjsComponent({
    wire: $wire,
    name: @js($name),
    initialContent: @js($grapesjsContent),
})" x-on:livewire:navigate.window="destroy()" wire:ignore>
    <div id="grapesjs_{{ $name }}" class="min-h-[90vh]"></div>
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
                        licenseKey: '{{ config('grapesjs.license-key') }}',
                        theme: 'light',
                        plugins: [
                            window.presetPrintable,
                            window.canvasFullSize,
                            window.tableComponent.init({
                                block: {
                                    category: 'Extra',
                                    label: 'My Table'
                                }
                            })
                        ],

                        // Custom fake storage handler
                        assets: {
                            storageType: 'self',
                            onUpload: async ({
                                files,
                                editor
                            }) => {
                                throw new Error('Das Hochladen von Bildern ist nicht implementiert.');
                            },
                            onDelete: async ({
                                assets,
                                editor
                            }) => {
                                throw new Error('Das Löschen von Bildern ist nicht implementiert.');
                            },
                            onLoad: async () => {
                                // Make logo available
                                return [{
                                    "name": "Venuzle Logo",
                                    "type": "image",
                                    "src": "http://localhost:8000/storage/assets/venuzle-logo.png",
                                }];
                            },
                        },

                        project: {
                            type: 'document',
                            default: {
                                assets: [{
                                    "name": "Venuzle Logo",
                                    "type": "image",
                                    "src": "http://localhost:8000/storage/assets/venuzle-logo.png",
                                }],
                                styles: [],
                                pages: [{
                                    name: 'Page',
                                    component: ''
                                }],
                                dataSources: [{
                                    id: "globalStyles",
                                    records: []
                                }]

                            }
                        },

                        globalStyles: {
                            default: []
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
                                                label: 'Elemente',
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
                                                }) => [
                                                    // Add custom print button
                                                    {
                                                        id: 'print',
                                                        tooltip: 'Print',
                                                        icon: '<svg viewBox="0 0 24 24"><path d="M18 3H6v4h12m1 5a1 1 0 0 1-1-1 1 1 0 0 1 1-1 1 1 0 0 1 1 1 1 1 0 0 1-1 1m-3 7H8v-5h8m3-6H5a3 3 0 0 0-3 3v6h4v4h12v-4h4v-6a3 3 0 0 0-3-3Z"/></svg>',
                                                        onClick: ({
                                                            editor
                                                        }) => editor.runCommand(
                                                            'presetPrintable:print')
                                                    },
                                                    ...items.filter(item => ![
                                                        'componentOutline',
                                                        'clearCanvas',
                                                        'store',
                                                        'fullscreen',
                                                    ].includes(item.id))
                                                ].map((e) => {
                                                    // Change icon for import
                                                    if (e.id == 'showImportCode') {
                                                        e.icon = 'codeBrackets';
                                                    }
                                                    return e;
                                                })
                                            }
                                        }
                                    },
                                    {
                                        type: 'sidebarRight'
                                    }
                                ]
                            }
                        },

                        i18n: {
                            locale: 'de',
                            locales: {
                                de: {
                                    blockManager: {
                                        notFound: "Keine Blöcke gefunden",
                                        blocks: "Blöcke",
                                        add: "Block hinzufügen",
                                        search: "Suchen...",
                                        types: {
                                            regular: "Normal",
                                            symbols: "Symbole"
                                        },
                                        symbols: {
                                            notFound: "Keine Symbole gefunden",
                                            instancesProject: "Instanz(en) im Projekt",
                                            delete: "Symbol löschen",
                                            deleteConfirm: "Möchten Sie das Symbol wirklich löschen? Alle Instanzen innerhalb des Projekts werden entfernt."
                                        }
                                    },
                                    fontManager: {
                                        addFontToProject: "Font zum Projekt hinzufügen",
                                        projectFonts: "Fonts im Projekt",
                                        emptyProjectFonts: "Es gibt keine Fonts in diesem Project.",
                                        selectFont: "Wähle eine Font"
                                    },
                                    dataSources: {
                                        confirm: "Bestätigen",
                                        clearDataValue: "Datenwert löschen",
                                        connectDataValue: "Datenwert verbinden",
                                        variable: "Variable",
                                        defaultValue: "Standardwert",
                                        variablePath: "Variablenpfad",
                                        selectVariablePath: "Variablenpfad auswählen",
                                        openPathExplorer: "Pfad-Explorer öffnen",
                                        closePathExplorer: "Pfad-Explorer schließen",
                                        toggleResolvedPath: "Aufgelösten Pfad umschalten",
                                        items: "{length} Element(e)",
                                        properties: "{length} Eigenschaft(en)",
                                        editVariable: "Variable bearbeiten",
                                        editCondition: "Bedingung bearbeiten",
                                        editCollection: "Schleife bearbeiten",
                                        condition: "Bedingung",
                                        conditionTrue: "Wahre Bedingung",
                                        conditionFalse: "Falsche Bedingung",
                                        conditionAnd: "UND",
                                        conditionOr: "ODER",
                                        conditionElse: "Sonst",
                                        addCondition: "Bedingung hinzufügen",
                                        deleteCondition: "Bedingung löschen",
                                        operator: "Operator",
                                        leftValue: "Linker Wert",
                                        rightValue: "Rechter Wert",
                                        ifTrue: "Wert bei wahr",
                                        ifFalse: "Wert bei falsch",
                                        valueTrue: "Wahr",
                                        valueFalse: "Falsch",
                                        collection: "Schleife",
                                        collectionItem: "Schleifenelement",
                                        collectionId: "Schleifen-ID",
                                        collectionStartIndex: "Startindex",
                                        collectionEndIndex: "Endindex",
                                        collectionUpToEndIndex: "Alle",
                                        operators: {
                                            "=": "= (Gleich)",
                                            "!=": "!= (Ungleich)",
                                            ">": "> (Größer als)",
                                            ">=": ">= (Größer als oder gleich)",
                                            "<": "< (Kleiner als)",
                                            "<=": "<= (Kleiner oder gleich)",
                                            contains: "Enthält",
                                            startsWith: "Beginnt mit",
                                            endsWith: "Endet mit",
                                            matchesRegex: "Entspricht regulärem Ausdruck",
                                            equalsIgnoreCase: "Gleich (Groß-/Kleinschreibung ignorieren)",
                                            trimEquals: "Gleich (gekürzt)",
                                            and: "UND",
                                            or: "ODER",
                                            xor: "XOR",
                                            equals: "Gleich",
                                            isDefined: "Ist definiert",
                                            isNull: "Ist null",
                                            isUndefined: "Ist undefiniert",
                                            isTruthy: "Ist wahr",
                                            isFalsy: "Ist falsch",
                                            isDefaultValue: "Ist Standardwert",
                                            isArray: "Ist Array",
                                            isObject: "Ist Objekt",
                                            isString: "Ist Zeichenfolge",
                                            isNumber: "Ist Zahl",
                                            isBoolean: "Ist Boolescher Wert"
                                        }
                                    },
                                    pageManager: {
                                        pages: 'Seiten',
                                        page: 'Seite',
                                        newPage: 'Neue Seite',
                                        add: 'Seite hinzufügen',
                                        rename: 'Umbennen',
                                        duplicate: 'Duplizieren',
                                        copy: 'Kopieren',
                                        delete: 'Löschen',
                                        deletePage: 'Seite löschen',
                                        confirmDelete: 'Möchten Sie die Seite wirklich löschen?',
                                        settings: {
                                            label: 'Einstellungen',
                                            title: 'Seiteneintstellungen',
                                            global: 'Globale Einstellungen',
                                            fields: {
                                                name: {
                                                    label: 'Name'
                                                },
                                                slug: {
                                                    label: 'Kürzel',
                                                    description: '...'
                                                },
                                                favicon: {
                                                    label: 'Favicon',
                                                    description: '...'
                                                },
                                                title: {
                                                    label: 'Titel',
                                                    description: '...'
                                                },
                                                description: {
                                                    label: 'Beschreibung',
                                                    description: '...'
                                                },
                                                keywords: {
                                                    label: 'Keywords',
                                                    description: '...'
                                                },
                                                socialTitle: {
                                                    label: 'Sozialer Titel',
                                                    description: '...'
                                                },
                                                socialImage: {
                                                    label: 'Soziales Bild',
                                                    description: '...'
                                                },
                                                socialDescription: {
                                                    label: 'Soziale Beschreibung',
                                                    description: '...'
                                                },
                                                customCodeHead: {
                                                    label: 'Benutzerdefinierter HTML Header',
                                                    description: '...'
                                                },
                                                customCodeBody: {
                                                    label: 'Benutzerdefinierter HTML Body',
                                                    description: '...'
                                                }
                                            }
                                        }
                                    },
                                    styleManager: {
                                        sectors: {
                                            general: 'Allgemein',
                                            layout: 'Layout',
                                            typography: 'Typography',
                                            decorations: 'Dekorationen',
                                            extra: 'Extras',
                                            flex: 'Flex',
                                            dimension: 'Dimension',
                                        },
                                        properties: {
                                            width: 'Breite',
                                            height: 'Höhe',
                                            'min-width': 'Min. Breite',
                                            'min-height': 'Min. Höhe',
                                            'max-width': 'Max. Breite',
                                            'max-height': 'Max. Höhe',
                                            'text-shadow-h': 'X',
                                            'text-shadow-v': 'Y',
                                            'text-shadow-blur': 'Blur',
                                            'text-shadow-color': 'Farbe',
                                            'box-shadow-h': 'X',
                                            'box-shadow-v': 'Y',
                                            'box-shadow-blur': 'Blur',
                                            'box-shadow-spread': 'Spread',
                                            'box-shadow-color': 'Farbe',
                                            'box-shadow-type': 'Typ',
                                            'margin-top-sub': 'Oben',
                                            'margin-right-sub': 'Rechts',
                                            'margin-bottom-sub': 'Unten',
                                            'margin-left-sub': 'Links',
                                            'padding-top-sub': 'Oben',
                                            'padding-right-sub': 'Rechts',
                                            'padding-bottom-sub': 'Unten',
                                            'padding-left-sub': 'Links',
                                            'border-width-sub': 'Breite',
                                            'border-style-sub': 'Stil',
                                            'border-color-sub': 'Farbe',
                                            'border-top-left-radius-sub': 'Oben links',
                                            'border-top-right-radius-sub': 'Oben rechts',
                                            'border-bottom-right-radius-sub': 'Unten rechts',
                                            'border-bottom-left-radius-sub': 'Unten links',
                                            'transform-rotate-x': 'X drehen',
                                            'transform-rotate-y': 'Y drehen',
                                            'transform-rotate-z': 'Z drehen',
                                            'transform-scale-x': 'X skalieren',
                                            'transform-scale-y': 'Y skalieren',
                                            'transform-scale-z': 'Z skalieren',
                                            'transition-property-sub': 'Eigenschaft',
                                            'transition-duration-sub': 'Dauer',
                                            'transition-timing-function-sub': 'Timing',
                                            'background-image-sub': 'Bild',
                                            'background-repeat-sub': 'Wiederholen',
                                            'background-position-sub': 'Position',
                                            'background-attachment-sub': 'Anhang',
                                            'background-size-sub': 'Größe',
                                        },
                                        options: {},
                                    },
                                }
                            }
                        },

                        dataSources: {
                            blocks: true, // This enables the Data Source specific blocks
                            globalStyles: {},
                            globalData: { // Provide default globalData for the project
                                operator: {
                                    name: 'Venuzle GmbH',
                                    address: 'Musterstraße 6, 27550 Musterstadt',
                                    phone: '+43 000 000 0000',
                                    fax: '+43 000 000 0000',
                                    email: 'hallo@venuzle.at',
                                    iban: 'AT00 0000 0000 0000 0000',
                                    bic: 'FABAATGR',
                                },
                                recipient: {
                                    id: '5034',
                                    name: 'Kim Mustermensch',
                                    address: {
                                        street: 'Lange Straße 42',
                                        city: '25928 Erste Stadt',
                                    },
                                },
                                invoice: {
                                    id: 'R2304-25',
                                    date: '02.12.2025',
                                    dueDate: '16.12.2025',
                                    positions: [{
                                        id: '12345',
                                        name: 'Klopapier',
                                        amount: '2',
                                        price: '4,99',
                                        sum: '9.98',
                                    }, {
                                        id: '23456',
                                        name: 'Seife',
                                        amount: '1',
                                        price: '3,99',
                                        sum: '3.99',
                                    }, {
                                        id: '45678',
                                        name: 'Teelichter (20 St.)',
                                        amount: '2',
                                        price: '5,99',
                                        sum: '11.98',
                                    }, ],
                                    sum: '25,95',
                                    vat: '4,33',
                                }
                            },
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

                            onLoad: ({
                                editor
                            }) => {
                                const sm = editor.StyleManager;
                                const unitsToAdd = ['cm', 'mm'];

                                // Loop through all sectors & properties so we cann add the units
                                sm.getSectors().forEach(sector => {
                                    sector.getProperties().forEach(prop => {

                                        // CASE 1: direct numeric property (width, height, font-size, etc.)
                                        if (prop.get('type') === 'number') {
                                            const units = prop.get('units') || [];
                                            prop.set('units', [...new Set([...units, ...
                                                unitsToAdd
                                            ])]);
                                        }

                                        // CASE 2: composite property (margin, padding, border-radius, etc.)
                                        if (prop.get('type') === 'composite') {
                                            prop.get('properties').forEach(subProp => {
                                                if (subProp.get('type') ===
                                                    'number') {
                                                    const units = subProp.get(
                                                        'units') || [];
                                                    subProp.set('units', [...
                                                        new Set([...
                                                            units,
                                                            ...
                                                            unitsToAdd
                                                        ])
                                                    ]);
                                                }
                                            });
                                        }
                                    });
                                });

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
