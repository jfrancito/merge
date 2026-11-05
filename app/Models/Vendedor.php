<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendedor extends Model
{
    protected $table = 'vendedores';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
        'porcentaje_comision' => 'float',
        'comision_fija' => 'float',
        'activo' => 'integer',
        'fecha_crea' => 'datetime',
        'fecha_modifica' => 'datetime',
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function ventas()
    {
        return $this->hasMany(VentaLote::class, 'vendedor_id', 'id');
    }

    public function getNombreCompletoAttribute()
    {
        return trim("{$this->nombre} {$this->apellidos}");
    }
}
