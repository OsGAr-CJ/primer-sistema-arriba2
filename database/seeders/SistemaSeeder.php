<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Sistema;
use Illuminate\Database\Seeder;

class SistemaSeeder extends Seeder {
    public function run(): void {
        $sistemas = ['Nómina', 'Inventarios', 'Punto de Venta', 'Correo Institucional', 'ERP Central'];
        foreach ($sistemas as $s) {
            Sistema::create(['nombre_sistema' => $s]);
        }
    }
}