<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PagoCuota extends Model
{
    protected $table = 'pagos_cuotas';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
        'monto_pagado' => 'float',
        'mora_pagada' => 'float',
        'fecha_pago' => 'date',
        'activo' => 'integer',
        'fecha_crea' => 'datetime',
    ];

    public function venta()
    {
        return $this->belongsTo(VentaLote::class, 'venta_id', 'id');
    }

    public function cuota()
    {
        return $this->belongsTo(CuotaCronograma::class, 'cuota_id', 'id');
    }
}
