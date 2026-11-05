<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CuotaCronograma extends Model
{
    protected $table = 'cuotas_cronograma';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
        'numero_cuota' => 'integer',
        'monto_cuota' => 'float',
        'monto_pagado' => 'float',
        'monto_mora' => 'float',
        'saldo_pendiente' => 'float',
        'fecha_vencimiento' => 'date',
        'fecha_ultimo_pago' => 'date',
        'activo' => 'integer',
        'fecha_crea' => 'datetime',
        'fecha_modifica' => 'datetime',
    ];

    public function venta()
    {
        return $this->belongsTo(VentaLote::class, 'venta_id', 'id');
    }

    public function pagos()
    {
        return $this->hasMany(PagoCuota::class, 'cuota_id', 'id');
    }

    public function getEstadoBadgeAttribute()
    {
        $hoy = date('Y-m-d');
        if ($this->estado === 'pagado') {
            return '<span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1 rounded-pill fs-12 fw-medium">Pagado</span>';
        }
        if ($this->fecha_vencimiento < $hoy) {
            return '<span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2 py-1 rounded-pill fs-12 fw-medium">Vencido</span>';
        }
        if ($this->monto_pagado > 0) {
            return '<span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 px-2 py-1 rounded-pill fs-12 fw-medium">Parcial</span>';
        }
        return '<span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 px-2 py-1 rounded-pill fs-12 fw-medium">Pendiente</span>';
    }
}
