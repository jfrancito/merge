<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VentaLote extends Model
{
    protected $table = 'ventas_lotes';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
        'precio_lote' => 'float',
        'descuento' => 'float',
        'precio_final' => 'float',
        'monto_inicial' => 'float',
        'saldo_financiar' => 'float',
        'numero_cuotas' => 'integer',
        'monto_cuota_mensual' => 'float',
        'dia_pago_mensual' => 'integer',
        'fecha_primer_vencimiento' => 'date',
        'fecha_venta' => 'date',
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

    public function lote()
    {
        return $this->belongsTo(Lote::class, 'lote_id', 'id');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id', 'id');
    }

    public function vendedor()
    {
        return $this->belongsTo(Vendedor::class, 'vendedor_id', 'id');
    }

    public function cuotas()
    {
        return $this->hasMany(CuotaCronograma::class, 'venta_id', 'id')->orderBy('numero_cuota', 'asc');
    }

    public function pagos()
    {
        return $this->hasMany(PagoCuota::class, 'venta_id', 'id')->orderBy('fecha_pago', 'desc');
    }

    // Estadísticas de cobranza
    public function getMontoTotalPagadoAttribute()
    {
        return $this->cuotas()->sum('monto_pagado');
    }

    public function getSaldoPendienteTotalAttribute()
    {
        return $this->cuotas()->where('estado', '!=', 'pagado')->sum('saldo_pendiente');
    }

    public function getCuotasPagadasCountAttribute()
    {
        return $this->cuotas()->where('estado', 'pagado')->count();
    }

    public function getCuotasPendientesCountAttribute()
    {
        return $this->cuotas()->where('estado', 'pendiente')->count();
    }

    public function getCuotasVencidasCountAttribute()
    {
        return $this->cuotas()->where('estado', 'vencido')->count();
    }

    public function getEstadoBadgeAttribute()
    {
        return match ($this->estado) {
            'activo' => '<span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1 rounded-pill fs-12 fw-medium">Activo / Vigente</span>',
            'cancelado_total' => '<span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-2 py-1 rounded-pill fs-12 fw-medium">Cancelado Total</span>',
            'rescindido' => '<span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2 py-1 rounded-pill fs-12 fw-medium">Rescindido</span>',
            default => '<span class="badge bg-light text-dark px-2 py-1 fs-12">' . ucfirst($this->estado) . '</span>'
        };
    }
}
