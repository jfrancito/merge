<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{
    protected $table = 'lotes';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
        'area_m2' => 'float',
        'medida_frente' => 'float',
        'medida_fondo' => 'float',
        'medida_izquierda' => 'float',
        'medida_derecha' => 'float',
        'precio_m2' => 'float',
        'precio_total' => 'float',
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

    public function manzana()
    {
        return $this->belongsTo(Manzana::class, 'manzana_id', 'id');
    }

    // Helper para badge de estado
    public function getEstadoBadgeAttribute()
    {
        return match ($this->estado) {
            'disponible' => '<span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1 rounded-pill fs-12 fw-medium">Disponible</span>',
            'reservado', 'separado' => '<span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 px-2 py-1 rounded-pill fs-12 fw-medium">Separado / Reservado</span>',
            'vendido' => '<span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2 py-1 rounded-pill fs-12 fw-medium">Vendido</span>',
            'bloqueado' => '<span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 px-2 py-1 rounded-pill fs-12 fw-medium">Bloqueado</span>',
            default => '<span class="badge bg-light text-dark px-2 py-1 fs-12">' . ucfirst($this->estado) . '</span>'
        };
    }

    // Helper para nombre completo de lote (ej: "Mz. A - Lote 04")
    public function getNombreCompletoAttribute()
    {
        $mz = $this->manzana ? $this->manzana->nombre : 'Sin Mz';
        return "{$mz} - {$this->numero_lote}";
    }

    public function getPrecioVentaAttribute()
    {
        return $this->precio_total ?? 0.00;
    }
}
