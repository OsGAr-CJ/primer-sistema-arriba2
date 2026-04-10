<?php

namespace App\Exports;

use App\Models\Incidencia;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class IncidenciasExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Traemos las incidencias con sus relaciones para que no salga vacío
        return Incidencia::with(['sistema', 'area', 'tipoIncidencia'])->get();
    }

    /**
    * Definir los encabezados de las columnas
    */
    public function headings(): array
    {
        return [
            'ID',
            'Sistema',
            'Tipo de Incidencia',
            'Área',
            'Descripción',
            'Observaciones',
            'Fecha de Reporte',
        ];
    }

    /**
    * Mapear los datos para que salgan los nombres y no los IDs
    */
    public function map($incidencia): array
    {
        return [
            $incidencia->id,
            $incidencia->sistema->nombre_sistema ?? 'N/A',
            $incidencia->tipoIncidencia->nombre_tipo ?? 'N/A',
            $incidencia->area->nombre_area ?? 'N/A',
            $incidencia->descripcion,
            $incidencia->observaciones ?? 'Sin observaciones',
            $incidencia->created_at->format('d/m/Y H:i'),
        ];
    }
}