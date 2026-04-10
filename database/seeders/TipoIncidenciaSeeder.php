<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\TipoIncidencia;
use Illuminate\Database\Seeder;

class TipoIncidenciaSeeder extends Seeder {
    public function run(): void {
        $tipos = ['Falla de Hardware', 'Error de Software', 'Acceso/Contraseña', 'Red/Internet', 'Mantenimiento'];
        foreach ($tipos as $t) {
            TipoIncidencia::create(['nombre_tipo' => $t]);
        }
    }
}