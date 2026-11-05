<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Manzana extends Model
{
    protected $table = 'manzanas';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
        'orden' => 'integer',
        'activo' => 'integer',
        'fecha_crea' => 'datetime',
        'fecha_modifica' => 'datetime',
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id', 'id');
    }

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_id', 'id');
    }

    public function lotes()
    {
        return $this->hasMany(Lote::class, 'manzana_id', 'id')->orderBy('numero_lote', 'asc');
    }

    // Contadores por manzana
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
