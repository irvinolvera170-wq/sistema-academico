<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MiInformacionController extends Controller
{
    public function __invoke(Request $request)
    {
        // La ficha sale de la sesión, no de la URL: nadie puede ver la de otro alumno
        $alumno = $request->user()->alumno()->firstOrFail();

        return view('alumno.informacion', compact('alumno'));
    }
}