<?php

namespace App\Livewire\Components;

use Livewire\Attributes\Modelable;
use Livewire\Component;

class Grapesjs extends Component
{
    /**
     * The content of the GrapesJS instance.
     * This property is bound to Livewire and will trigger updates when changed.
     * Made public so Livewire can serialize and bind it to the frontend.
     */
    #[Modelable]
    public mixed $grapesjsContent = null;

    public string $name = 'field';

    public function mount(?string $name = null): void
    {
        $this->name = $name ?? 'field';
    }
}
