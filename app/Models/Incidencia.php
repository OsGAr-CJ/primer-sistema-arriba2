<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Incidencia extends Model
{
    // Esto le dice a Laravel qué campos puede llenar desde el formulario
    protected $fillable = [
        'sistema_id', 
        'tipo_incidencia_id', 
        'area_id', 
        'descripcion', 
        'observaciones', 
        'evidencia'
    ];

    public function sistema() {
        return $this->belongsTo(Sistema::class,'sistema_id');
    }

    public function tipoIncidencia() {
        return $this->belongsTo(TipoIncidencia::class, 'tipo_incidencia_id');
    }

    public function area() {
    return $this->belongsTo(Area::class, 'area_id');
}
}