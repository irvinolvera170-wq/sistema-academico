@props(['columna', 'titulo'])

@php
    $ordenActual = request('orden', 'nombre');
    $dirActual = request('dir') === 'desc' ? 'desc' : 'asc';
    $activa = $ordenActual === $columna;
    $nuevaDir = ($activa && $dirActual === 'asc') ? 'desc' : 'asc';
    $url = request()->fullUrlWithQuery(['orden' => $columna, 'dir' => $nuevaDir, 'page' => null]);
@endphp

<th>
    <a href="{{ $url }}" class="text-decoration-none text-dark">
        {{ $titulo }}
        @if ($activa) {{ $dirActual === 'asc' ? '▲' : '▼' }} @endif
    </a>
</th>