@props(['value' => 0])

@php
    $value = max(0, min(5, (float) $value));
    $full = (int) floor($value);
    $half = ($value - $full) >= 0.5 ? 1 : 0;
    $empty = 5 - $full - $half;
@endphp

<span {{ $attributes->merge(['class' => 'stars text-warning text-nowrap']) }}
      role="img" aria-label="{{ number_format($value, 1) }} out of 5 stars">
    @for ($i = 0; $i < $full; $i++)<i class="bi bi-star-fill"></i>@endfor
    @if ($half)<i class="bi bi-star-half"></i>@endif
    @for ($i = 0; $i < $empty; $i++)<i class="bi bi-star"></i>@endfor
</span>
