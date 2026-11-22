@php $editando = isset($alumno); @endphp

<div class="mb-3">
    <label class="form-label">Nombre</label>
    <input type="text" name="name" value="{{ old('name', $alumno->user->name ?? '') }}"
           class="form-control @error('name') is-invalid @enderror">
    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Correo</label>
    <input type="email" name="email" value="{{ old('email', $alumno->user->email ?? '') }}"
           class="form-control @error('email') is-invalid @enderror">
    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Contraseña</label>
    <input type="password" name="password"
           class="form-control @error('password') is-invalid @enderror">
    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
    @if ($editando) <div class="form-text">Déjala en blanco para conservar la actual.</div> @endif
</div>

<div class="mb-3">
    <label class="form-label">Confirmar contraseña</label>
    <input type="password" name="password_confirmation" class="form-control">
</div>

<div class="row">
    <div class="col-6 mb-3">
        <label class="form-label">Faltas</label>
        <input type="number" name="faltas" min="0" max="100" step="1"
               value="{{ old('faltas', $alumno->faltas ?? 0) }}"
               class="form-control @error('faltas') is-invalid @enderror">
        @error('faltas') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-6 mb-3">
        <label class="form-label">Calificación (0 a 10)</label>
        <input type="number" name="calificacion" min="0" max="10" step="0.1"
               value="{{ old('calificacion', isset($alumno) ? number_format($alumno->calificacion, 1, '.', '') : '') }}"
               class="form-control @error('calificacion') is-invalid @enderror">
        @error('calificacion') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<div class="form-text mb-3">La equivalencia (NA, SA, DE, AU) se calcula automáticamente.</div>