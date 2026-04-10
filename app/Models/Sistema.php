<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sistema extends Model
{
    protected $fillable = ['nombre_sistema'];
    
    public function incidencias() {
        return $this->hasMany(Incidencia::class);
    }
}
