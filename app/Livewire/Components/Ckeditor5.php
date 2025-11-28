<?php

namespace App\Livewire\Components;

use Livewire\Attributes\Modelable;
use Livewire\Component;

class Ckeditor5 extends Component
{
    /**
     * The content of the CKEditor5 instance.
     * This property is bound to Livewire and will trigger updates when changed.
     * Made public so Livewire can serialize and bind it to the frontend.
     *
     * @var array<string, string> Content sections, e.g., ['main' => '<p>Initial content</p>']
     */
    #[Modelable]
    public mixed $ckeditorContent = null;

    public string $name = 'field';

    public function mount(?string $name = null): void
    {
        $this->name = $name;
    }
}
