<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    protected $table = 'proyectos';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
        'precio_m2_referencial' => 'float',
        'activo' => 'integer',
        'fecha_crea' => 'datetime',
        'fecha_modifica' => 'datetime',
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id', 'id');
    }

    public function manzanas()
    {
        return $this->hasMany(Manzana::class, 'proyecto_id', 'id')->orderBy('orden', 'asc');
    }

    public function lotes()
    {
        return $this->hasMany(Lote::class, 'proyecto_id', 'id');
    }

    // Contadores de estados de lotes
    public function getLotesTotalesAttribute()
    {
        return $this->lotes()->where('activo', 1)->count();
    }

    public function getLotesDisponiblesAttribute()
    {
        return $this->lotes()->where('activo', 1)->where('estado', 'disponible')->count();
    }

    public function getLotesReservadosAttribute()
    {
        return $this->lotes()->where('activo', 1)->where('estado', 'reservado')->count();
    }

    public function getLotesVendidosAttribute()
    {
        return $this->lotes()->where('activo', 1)->where('estado', 'vendido')->count();
    }
}
