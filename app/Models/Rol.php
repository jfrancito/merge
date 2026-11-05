<?php

namespace App\Models; // Cambio recomendado

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\BelongsToEmpresa;

class Rol extends Model
{
    use BelongsToEmpresa;
    protected $table = 'rols';
    public $timestamps = false;

    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

    public function user(): HasMany
    {
        return $this->hasMany('App\Models\User', 'rol_id', 'id');
    }

    public function rolopcion(): HasMany
    {
        return $this->hasMany('App\Models\RolOpcion', 'rol_id', 'id');
    }
}