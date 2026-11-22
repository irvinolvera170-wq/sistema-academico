<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AlumnoRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Segunda barrera además del middleware: solo un profesor puede enviar este formulario
        return $this->user()?->esProfesor() ?? false;
    }

    public function rules(): array
    {
        $alumno = $this->route('alumno');   // null al registrar
        $editando = $alumno !== null;

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255',
                Rule::unique('users', 'email')->ignore($alumno?->user_id)],
            'password' => [$editando ? 'nullable' : 'required', 'min:8', 'confirmed'],
            'faltas' => ['required', 'integer', 'between:0,100'],
            'calificacion' => ['required', 'numeric', 'between:0,10', 'decimal:0,1'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Escribe el nombre del alumno.',
            'name.max' => 'El nombre no puede tener más de 255 caracteres.',
            'email.required' => 'Escribe el correo del alumno.',
            'email.email' => 'Escribe un correo válido, por ejemplo nombre@correo.com.',
            'email.unique' => 'Este correo ya está registrado.',
            'password.required' => 'Escribe una contraseña.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'faltas.required' => 'Escribe el número de faltas.',
            'faltas.integer' => 'Las faltas deben ser un número entero.',
            'faltas.between' => 'Las faltas deben estar entre 0 y 100.',
            'calificacion.required' => 'Escribe la calificación.',
            'calificacion.numeric' => 'La calificación debe ser un número.',
            'calificacion.between' => 'La calificación debe estar entre 0 y 10.',
            'calificacion.decimal' => 'La calificación admite máximo un decimal.',
        ];
    }
}