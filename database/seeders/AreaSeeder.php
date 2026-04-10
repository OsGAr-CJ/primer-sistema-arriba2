<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Area;
use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder {
    public function run(): void {
        $areas = ['Sistemas', 'Recursos Humanos', 'Contabilidad', 'Ventas', 'Almacén'];
        foreach ($areas as $a) {
            Area::create(['nombre_area' => $a]);
        }
    }
}