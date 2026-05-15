<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barrio extends Model
{
    protected $fillable = [
        'nombre',
        'distrito',
        'codigo_postal',
    ];

    public function incidencias()
    {
        return $this->hasMany(Incidencia::class);
    }
}
