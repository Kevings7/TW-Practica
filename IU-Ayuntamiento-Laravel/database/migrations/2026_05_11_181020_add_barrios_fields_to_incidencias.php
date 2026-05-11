<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('barrios')) {
            Schema::create('barrios', function (Blueprint $table) {
                $table->id();
                $table->string('nombre', 100);
                $table->string('distrito', 100)->nullable();
                $table->string('codigo_postal', 10)->nullable();
                $table->timestamps();
            });
        }

        Schema::table('incidencias', function (Blueprint $table) {
            if (!Schema::hasColumn('incidencias', 'barrio_id')) {
                $table->foreignId('barrio_id')->nullable()->after('estado_incidencia_id')->constrained('barrios');
            }

            if (!Schema::hasColumn('incidencias', 'codigo_postal')) {
                $table->string('codigo_postal', 10)->nullable()->after('direccion');
            }

            if (!Schema::hasColumn('incidencias', 'fecha_incidencia')) {
                $table->date('fecha_incidencia')->nullable()->after('codigo_postal');
            }
        });
    }

    public function down(): void
    {
        Schema::table('incidencias', function (Blueprint $table) {
            if (Schema::hasColumn('incidencias', 'barrio_id')) {
                $table->dropForeign(['barrio_id']);
                $table->dropColumn('barrio_id');
            }

            if (Schema::hasColumn('incidencias', 'codigo_postal')) {
                $table->dropColumn('codigo_postal');
            }

            if (Schema::hasColumn('incidencias', 'fecha_incidencia')) {
                $table->dropColumn('fecha_incidencia');
            }
        });

        Schema::dropIfExists('barrios');
    }
};