<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoIncidencia extends Model
{
    protected $table = 'tipos_incidencia';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public function incidencias()
    {
        return $this->hasMany(Incidencia::class);
    }
}