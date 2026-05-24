<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    protected $table = 'notificaciones';

    protected $fillable = [
        'usuario_id',
        'incidencia_id',
        'titulo',
        'mensaje',
        'leida',
    ];

    // Relación: una notificación pertenece a un usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    // Relación: una notificación puede estar ligada a una incidencia
    public function incidencia()
    {
        return $this->belongsTo(Incidencia::class);
    }
}
