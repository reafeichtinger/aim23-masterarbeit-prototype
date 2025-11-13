<x-container>

    {{-- Main content --}}
    <div class="card px-6 py-4 space-y-4">
        <x-header title="Aufgabe 1" />

        <x-ckeditor name="document" :value="$this->content" wire:model="content" />
    </div>

</x-container>
