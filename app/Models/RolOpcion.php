<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Facades\Hashids;

class RolOpcion extends Model
{
    protected $table = 'rolopciones';
    public $timestamps = false;

    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

    protected $appends = ['hash'];

    public function getHashAttribute()
    {
        return Hashids::encode(substr($this->id, -8));
    }

    /**
     * Relación con la opción
     */
    public function opcion(): BelongsTo
    {
        return $this->belongsTo(Opcion::class, 'opcion_id', 'id');
    }

    /**
     * Relación con el rol
     */
    public function rol(): BelongsTo
    {
        return $this->belongsTo(Rol::class, 'rol_id', 'id'); // Corregido
    }
}