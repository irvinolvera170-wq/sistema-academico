@extends('layouts.app')

@section('title', 'Mi información académica')

@section('content')
<div class="container py-5 d-flex justify-content-center">
    <div class="card shadow-sm w-100" style="max-width: 480px;">
        <div class="card-body p-4">
            <h3 class="mb-4">Mi información académica</h3>

            <dl class="row mb-0">
                <dt class="col-sm-5">Nombre</dt>
                <dd class="col-sm-7">{{ auth()->user()->name }}</dd>

                <dt class="col-sm-5">Número de faltas</dt>
                <dd class="col-sm-7">{{ $alumno->faltas }}</dd>

                <dt class="col-sm-5">Calificación</dt>
                <dd class="col-sm-7">{{ number_format($alumno->calificacion, 1) }}</dd>

                <dt class="col-sm-5">Equivalencia</dt>
                <dd class="col-sm-7"><x-equivalencia :valor="$alumno->equivalencia" /></dd>
            </dl>

            <p class="text-muted small mt-4 mb-0">Esta información es solo de consulta.</p>
        </div>
    </div>
</div>
@endsection