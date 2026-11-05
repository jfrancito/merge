<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
        'activo' => 'integer',
        'fecha_crea' => 'datetime',
        'fecha_modifica' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($cliente) {
            if (empty($cliente->razon_social)) {
                $cliente->razon_social = $cliente->nombre_completo ?: $cliente->nombre_razon_social;
            }
            if (empty($cliente->nombre_razon_social)) {
                $cliente->nombre_razon_social = $cliente->razon_social;
            }
            if (empty($cliente->correo) && !empty($cliente->email)) {
                $cliente->correo = $cliente->email;
            }
            if (empty($cliente->email) && !empty($cliente->correo)) {
                $cliente->email = $cliente->correo;
            }
        });
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id', 'id');
    }

    public function ventas()
    {
        return $this->hasMany(VentaLote::class, 'cliente_id', 'id');
    }

    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'cliente_id', 'id');
    }

    public function cotizaciones()
    {
        return $this->hasMany(Cotizacion::class, 'cliente_id', 'id');
    }

    public function getNombreCompletoAttribute()
    {
        if ($this->tipo_documento === 'RUC') {
            return $this->nombre_razon_social;
        }
        return trim("{$this->nombre_razon_social} {$this->apellidos}");
    }
}
