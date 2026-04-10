<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $fillable = ['nombre_area', 'usuario_reporta'];

    public function incidencias() {
        return $this->hasMany(Incidencia::class);
    }
}

