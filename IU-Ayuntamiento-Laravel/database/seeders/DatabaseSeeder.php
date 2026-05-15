<?php

namespace Database\Seeders;

use App\Models\Barrio;
use App\Models\EstadoIncidencia;
use App\Models\Role;
use App\Models\TipoIncidencia;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $ciudadano = Role::updateOrCreate(
            ['nombre' => 'ciudadano'],
            ['descripcion' => 'Usuario normal que puede reportar incidencias.']
        );

        $tecnico = Role::updateOrCreate(
            ['nombre' => 'tecnico'],
            ['descripcion' => 'Usuario con permisos especiales para gestionar incidencias.']
        );

        User::updateOrCreate(
            ['email' => 'tecnico@granada.es'],
            [
                'role_id' => $tecnico->id,
                'name' => 'Usuario',
                'apellidos' => 'Técnico',
                'telefono' => '600000002',
                'password' => Hash::make('1234'),
                'activo' => true,
            ]
        );

        $tipos = [
            ['nombre' => 'Farola rota', 'descripcion' => 'Farola apagada, rota o con funcionamiento incorrecto'],
            ['nombre' => 'Zona sin iluminación', 'descripcion' => 'Calle o zona con iluminación insuficiente'],
            ['nombre' => 'Basura acumulada', 'descripcion' => 'Acumulación de basura en la vía pública'],
            ['nombre' => 'Contenedor roto', 'descripcion' => 'Contenedor dañado o inutilizable'],
            ['nombre' => 'Bache en calzada', 'descripcion' => 'Desperfecto en carretera o calle'],
            ['nombre' => 'Acerado en mal estado', 'descripcion' => 'Aceras rotas o peligrosas para peatones'],
            ['nombre' => 'Árbol caído', 'descripcion' => 'Árbol o rama caída en zona pública'],
            ['nombre' => 'Zona verde descuidada', 'descripcion' => 'Parque o jardín en mal estado'],
            ['nombre' => 'Banco roto', 'descripcion' => 'Banco público deteriorado'],
            ['nombre' => 'Señal dañada', 'descripcion' => 'Señal de tráfico o informativa rota'],
        ];

        foreach ($tipos as $tipo) {
            TipoIncidencia::updateOrCreate(
                ['nombre' => $tipo['nombre']],
                ['descripcion' => $tipo['descripcion']]
            );
        }

        $barrios = [
            ['nombre' => 'Centro', 'distrito' => 'Centro', 'codigo_postal' => '18001'],
            ['nombre' => 'Realejo', 'distrito' => 'Centro', 'codigo_postal' => '18009'],
            ['nombre' => 'Albaicín', 'distrito' => 'Albaicín', 'codigo_postal' => '18010'],
            ['nombre' => 'Sacromonte', 'distrito' => 'Albaicín', 'codigo_postal' => '18010'],
            ['nombre' => 'Zaidín', 'distrito' => 'Zaidín', 'codigo_postal' => '18007'],
            ['nombre' => 'Ronda', 'distrito' => 'Ronda', 'codigo_postal' => '18003'],
            ['nombre' => 'Chana', 'distrito' => 'Chana', 'codigo_postal' => '18015'],
            ['nombre' => 'Beiro', 'distrito' => 'Beiro', 'codigo_postal' => '18012'],
            ['nombre' => 'Genil', 'distrito' => 'Genil', 'codigo_postal' => '18008'],
            ['nombre' => 'Norte', 'distrito' => 'Norte', 'codigo_postal' => '18013'],
        ];

        foreach ($barrios as $barrio) {
            Barrio::updateOrCreate(
                ['nombre' => $barrio['nombre']],
                [
                    'distrito' => $barrio['distrito'],
                    'codigo_postal' => $barrio['codigo_postal'],
                ]
            );
        }

        EstadoIncidencia::updateOrCreate(
            ['nombre' => 'Pendiente'],
            []
        );

        EstadoIncidencia::updateOrCreate(
            ['nombre' => 'En proceso'],
            []
        );

        EstadoIncidencia::updateOrCreate(
            ['nombre' => 'Solucionado'],
            []
        );
    }
}