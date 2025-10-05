<x-layouts.base>

    {{-- Mobile navbar --}}
    <x-nav sticky class="lg:hidden">
        <x-slot:brand>
            <x-logo class="-m-2.5" />
        </x-slot:brand>
        <x-slot:actions>
            <label for="main-drawer" class="lg:hidden me-3">
                <x-icon name="o-bars-3-bottom-left" class="cursor-pointer" />
            </label>
        </x-slot:actions>
    </x-nav>

    {{-- Main --}}
    <x-main fullWidth>

        {{-- Sidebar --}}
        <x-slot:sidebar drawer="main-drawer" collapsible
            class="bg-base-100 rounded-e-2xl border-r-[length:var(--border)] border-neutral"
            collapse-icon="o-arrow-left-start-on-rectangle" collapse-text="Verkleinern">

            {{-- Brand --}}
            <x-logo />

            {{-- Divider --}}
            <div class="border-b-[length:var(--border)] border-neutral"></div>

            {{-- Menu --}}
            <x-menu activate-by-route active-bg-color="bg-secondary/25 text-secondary-content font-bold">

                {{-- Introduction --}}
                <x-menu-item title="Anweisungen" icon="o-information-circle" link="/" />

                {{-- Editors --}}
                <div class="pt-0">
                    <x-menu-sub title="Aufgaben" icon="o-numbered-list" open>

                        {{-- Rich text editor --}}
                        <x-menu-item title="1. Rich-Text" :link="route('task-1')" />

                        {{-- Drag and drop editor --}}
                        <x-menu-item title="2. Drag-and-drop" :link="route('task-2')" />

                    </x-menu-sub>
                </div>

            </x-menu>

        </x-slot:sidebar>

        {{-- Content --}}
        <x-slot:content>
            {{ $slot }}
        </x-slot:content>
    </x-main>

</x-layouts.base>
