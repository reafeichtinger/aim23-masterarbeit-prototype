<?php

namespace App\Support;

use Closure;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;

class AttrRenderer
{
    /**
     * Render the directive no matter the given arguments. This is needed because of method signature missmatches in some cases.
     */
    public function renderDirective(array $args, array $data = []): string
    {
        $attrs = $args[0] ?? '';
        $condition = $args[1] ?? null;

        return $this->render($attrs, $condition, $data);
    }

    /**
     * Actually render the directive.
     */
    public function render(string|array $attrs = '', null|bool|Closure $condition = null, array $data = []): string
    {
        // Single string attribute
        if (is_string($attrs)) {
            return $this->shouldRender($condition) ? $this->processBladeString($attrs, $data) : '';
        }

        // Multiple attributes
        if (is_array($attrs)) {
            $result = Collection::make();
            foreach ($attrs as $attr => $condition) {
                if ($this->shouldRender($condition)) {
                    $result->add($this->processBladeString($attr, $data));
                }
            }

            return $result->implode(' ');
        }

        return '';
    }

    /**
     * Determine if the given condition should allow rendering.
     */
    protected function shouldRender(null|bool|Closure $condition = null): bool
    {
        return $condition instanceof Closure ? ($condition() === true) : ($condition === true);
    }

    /**
     * Parse the content with blade including the available data.
     */
    protected function processBladeString(string $string, array $data = []): string
    {
        return trim(Blade::render($string, $data));
    }
}
