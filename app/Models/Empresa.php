<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table = 'empresas';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $guarded = [];

    protected $casts = [
        'configuracion' => 'array',
        'configuracion_simple' => 'array',
        'activo' => 'integer',
    ];

    public function users()
    {
        return $this->hasMany(User::class , 'empresa_id', 'id');
    }

    public function rols()
    {
        return $this->hasMany(Rol::class , 'empresa_id', 'id');
    }

    /**
     * Accessor for razon_social (maps to nombre)
     */
    public function getRazonSocialAttribute()
    {
        return $this->nombre;
    }

    /**
     * Accessor for nombre_comercial (maps to nombre)
     */
    public function getNombreComercialAttribute()
    {
        return $this->nombre;
    }
}
