<?php

namespace App\Models;  // Cambio recomendado

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Opcion extends Model
{
    protected $table = 'opciones';
    public $timestamps = false;

    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

    public function grupoopcion(): BelongsTo
    {
        return $this->belongsTo('App\Models\Grupoopcion', 'grupoopcion_id', 'id');
    }

    public function rolopcion(): HasMany
    {
        return $this->hasMany('App\Models\RolOpcion', 'opcion_id', 'id');
    }
}