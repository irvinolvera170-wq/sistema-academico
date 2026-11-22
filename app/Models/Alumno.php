<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['user_id', 'faltas', 'calificacion'])]
class Alumno extends Model
{
    protected function casts(): array
    {
        return ['calificacion' => 'decimal:1'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Equivalencia alfabética: se calcula, nunca se captura ni se guarda
    protected function equivalencia(): Attribute
    {
        return Attribute::get(function () {
            $calificacion = (float) $this->calificacion;

            return match (true) {
                $calificacion >= 10 => 'AU',
                $calificacion >= 9  => 'DE',
                $calificacion >= 8  => 'SA',
                default             => 'NA',
            };
        });
    }
}