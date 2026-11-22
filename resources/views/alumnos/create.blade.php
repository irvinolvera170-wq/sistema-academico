@extends('layouts.app')

@section('title', 'Registrar alumno')

@section('content')
<div class="container py-5 d-flex justify-content-center">
    <div class="card shadow-sm w-100" style="max-width: 480px;">
        <div class="card-body p-4">
            <h3 class="mb-4">Registrar alumno</h3>

            <form method="POST" action="{{ route('alumnos.store') }}" novalidate>
                @csrf
                @include('alumnos._form')
                <button type="submit" class="btn btn-primary w-100">Registrar</button>
            </form>

            <a href="{{ route('alumnos.index') }}" class="d-block text-center mt-3">← Volver a alumnos</a>
        </div>
    </div>
</div>
@endsection