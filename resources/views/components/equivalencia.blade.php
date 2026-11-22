@props(['valor'])

@php
    $mapa = [
        'NA' => ['danger', 'No Acreditado'],
        'SA' => ['warning text-dark', 'Suficiente'],
        'DE' => ['info text-dark', 'Destacado'],
        'AU' => ['success', 'Autónomo'],
    ];
    [$color, $texto] = $mapa[$valor];
@endphp

<span class="badge bg-{{ $color }}" title="{{ $texto }}">{{ $valor }}</span>