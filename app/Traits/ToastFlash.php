<?php

namespace App\Traits;

use Illuminate\Support\Facades\Session;

/**
 * Add custom flash support to mary-ui toasts.
 */
trait ToastFlash
{
    public function mountToastFlash(): void
    {
        if ($toast = Session::get('mary.toast-flash')) {
            $this->toast(
                type: $toast['type'] ?? '',
                title: $toast['title'] ?? '',
                description: $toast['description'] ?? '',
                position: $toast['position'] ?? '',
                icon: !str_starts_with($toast['icon'] ?? '', '<svg') ? $toast['icon'] : 'o-information-circle',
                css: $toast['css'] ?? 'alert-info',
                timeout: $toast['timeout'] ?? 3000,
            );
        }
    }
}
