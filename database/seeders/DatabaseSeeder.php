<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Profesor',
            'email' => 'profesor@test.com',
            'password' => 'password',   // el cast "hashed" del modelo la cifra
            'role' => 'profesor',
        ]);

        $alumnos = [
            ['Ana López', 'ana@test.com', 2, 9.5],
            ['Luis Pérez', 'luis@test.com', 5, 7.0],
            ['María Gómez', 'maria@test.com', 0, 10],
            ['Carlos Ruiz', 'carlos@test.com', 8, 8.4],
            ['Bruno Díaz', 'bruno@test.com', 12, 6.5],
        ];

        foreach ($alumnos as [$nombre, $correo, $faltas, $calificacion]) {
            $user = User::create([
                'name' => $nombre,
                'email' => $correo,
                'password' => 'password',
                'role' => 'alumno',
            ]);

            $user->alumno()->create([
                'faltas' => $faltas,
                'calificacion' => $calificacion,
            ]);
        }
    }
}