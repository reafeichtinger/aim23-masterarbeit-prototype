@props([
    'borderless' => false,
    'title' => __('general.empty_state'),
    'subtitle',
    'icon' => 'o-question-mark-circle',
    'iconClass' => 'h-20 w-20',
])
<div
    {{ $attributes->class(['relative w-full flex flex-col items-center justify-center rounded-box p-4 sm:p-6 lg:p-8 text-center text-base-content ', 'bg-base-100 shadow' => !$borderless]) }}>

    @if ($icon ?? null)
        <x-icon :name="$icon" class="{{ $iconClass }} mb-4 text-base-content/50" />
    @endif

    <h4 class="text-xl text-base-content font-bold w-full">
        {{ $title }}
    </h4>
    @if ($subtitle ?? null)
        <p class="text-base text-base-content/75 w-full">
            {{ $subtitle }}
        </p>
    @endif
</div>
