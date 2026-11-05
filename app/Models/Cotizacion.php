<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cotizacion extends Model
{
    protected $table = 'cotizaciones';
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
        'fecha_emision' => 'date',
        'fecha_vencimiento' => 'date',
        'activo' => 'integer',
        'fecha_crea' => 'datetime',
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
}
