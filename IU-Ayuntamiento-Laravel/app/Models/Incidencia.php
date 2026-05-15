<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Incidencia extends Model
{
    protected $fillable = [
        'user_id',
        'tipo_incidencia_id',
        'estado_incidencia_id',
        'barrio_id',
        'titulo',
        'descripcion',
        'direccion',
        'codigo_postal',
        'fecha_incidencia',
        'foto',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tipo()
    {
        return $this->belongsTo(TipoIncidencia::class, 'tipo_incidencia_id');
    }

    public function estado()
    {
        return $this->belongsTo(EstadoIncidencia::class, 'estado_incidencia_id');
    }

    public function barrio()
    {
        return $this->belongsTo(Barrio::class);
    }
}