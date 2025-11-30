<?php

namespace App\Livewire;

use App\Traits\ToastFlash;
use Livewire\Component as LivewireComponent;
use Mary\Traits\Toast;

class Component extends LivewireComponent
{
    use Toast, ToastFlash;

    public function redirectReload(): void
    {
        $this->redirect(request()->header('Referer'), navigate: true);
    }
}
