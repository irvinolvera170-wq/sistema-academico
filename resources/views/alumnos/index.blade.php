@extends('layouts.app')

@section('title', 'Alumnos')

@section('content')
<div class="container py-5">
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="mb-0">Alumnos</h3>
                <a href="{{ route('alumnos.create') }}" class="btn btn-primary btn-sm">+ Nuevo alumno</a>
            </div>

            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <x-th-ordenable columna="nombre" titulo="Alumno" />
                            <x-th-ordenable columna="faltas" titulo="Faltas" />
                            <x-th-ordenable columna="calificacion" titulo="Calificación" />
                            <th>Equivalencia</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($alumnos as $a)
                            <tr>
                                <td>
                                    {{ $a->nombre }}
                                    <div class="text-muted small">{{ $a->email }}</div>
                                </td>
                                <td>{{ $a->faltas }}</td>
                                <td>{{ number_format($a->calificacion, 1) }}</td>
                                <td><x-equivalencia :valor="$a->equivalencia" /></td>
                                <td class="text-end">
                                    <div class="d-inline-flex gap-1">
                                        <a href="{{ route('alumnos.edit', $a) }}" class="btn btn-sm btn-outline-primary">Editar</a>
                                        <form method="POST" action="{{ route('alumnos.destroy', $a) }}"
                                              onsubmit="return confirm('¿Eliminar a este alumno? Esta acción no se puede deshacer.')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger">Eliminar</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-muted">No hay alumnos registrados.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <p class="text-muted small mb-2">
                Mostrando {{ $alumnos->count() }} de {{ $alumnos->total() }} alumnos. Haz clic en un encabezado para ordenar.
            </p>

            {{ $alumnos->links() }}
        </div>
    </div>
</div>
@endsection