<?php

namespace App\Models;  // Cambio recomendado

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Grupoopcion extends Model
{
    protected $table = 'grupoopciones';
    public $timestamps = false;

    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

    public function opcion(): HasMany
    {
        return $this->hasMany('App\Models\Opcion', 'grupoopcion_id', 'id'); // Cambio de namespace
    }
}