<?php

namespace App\Http\Controllers;

use App\Http\Requests\AlumnoRequest;
use App\Models\Alumno;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlumnoController extends Controller
{
    public function index(Request $request)
    {
        // Lista blanca: solo estas columnas se pueden usar para ordenar
        $columnas = [
            'nombre' => 'users.name',
            'calificacion' => 'alumnos.calificacion',
            'faltas' => 'alumnos.faltas',
        ];

        $orden = $request->query('orden', 'nombre');
        $dir = $request->query('dir', 'asc');

        if (!isset($columnas[$orden])) {
            $orden = 'nombre';
        }
        if (!in_array($dir, ['asc', 'desc'], true)) {
            $dir = 'asc';
        }

        $alumnos = Alumno::query()
            ->join('users', 'users.id', '=', 'alumnos.user_id')
            ->select('alumnos.*', 'users.name as nombre', 'users.email')
            ->orderBy($columnas[$orden], $dir)
            ->paginate(10)
            ->withQueryString();

        return view('alumnos.index', compact('alumnos'));
    }

    public function create()
    {
        return view('alumnos.create');
    }

    public function store(AlumnoRequest $request)
    {
        $datos = $request->validated();

        DB::transaction(function () use ($datos) {
            $user = User::create([
                'name' => $datos['name'],
                'email' => $datos['email'],
                'password' => $datos['password'],
                'role' => 'alumno',          // el rol lo fija el servidor
            ]);

            $user->alumno()->create([
                'faltas' => $datos['faltas'],
                'calificacion' => $datos['calificacion'],
            ]);
        });

        return redirect()->route('alumnos.index')
            ->with('status', 'Alumno registrado correctamente.');
    }

    public function edit(Alumno $alumno)
    {
        $alumno->load('user');

        return view('alumnos.edit', compact('alumno'));
    }

    public function update(AlumnoRequest $request, Alumno $alumno)
    {
        $datos = $request->validated();

        DB::transaction(function () use ($datos, $alumno) {
            $usuario = [
                'name' => $datos['name'],
                'email' => $datos['email'],
            ];

            if (!empty($datos['password'])) {
                $usuario['password'] = $datos['password'];
            }

            $alumno->user->update($usuario);
            $alumno->update([
                'faltas' => $datos['faltas'],
                'calificacion' => $datos['calificacion'],
            ]);
        });

        return redirect()->route('alumnos.index')
            ->with('status', 'Alumno actualizado correctamente.');
    }

    public function destroy(Alumno $alumno)
    {
        $user = $alumno->user;

        DB::table('sessions')->where('user_id', $user->id)->delete();
        $user->delete();   // la llave foránea con cascade borra también la ficha del alumno

        return redirect()->route('alumnos.index')
            ->with('status', 'Alumno eliminado correctamente.');
    }
}