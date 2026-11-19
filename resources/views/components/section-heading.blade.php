@props(['eyebrow' => null, 'title', 'description' => null, 'center' => false])

<div @class(['max-w-3xl', 'mx-auto text-center' => $center]) data-aos="fade-up">
    @if ($eyebrow)
        <p class="section-eyebrow">{{ $eyebrow }}</p>
    @endif

    <h2 class="section-title {{ $eyebrow ? 'mt-3' : '' }}">{{ $title }}</h2>

    @if ($description)
        <p class="section-description {{ $center ? 'mx-auto' : '' }}">{{ $description }}</p>
    @endif

    {{ $slot }}
</div>
