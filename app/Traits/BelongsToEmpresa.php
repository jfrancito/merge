<?php

namespace App\Traits;

use App\Models\Empresa;
use Illuminate\Database\Eloquent\Builder;

trait BelongsToEmpresa
{
    /**
     * Boot the trait.
     */
    protected static function bootBelongsToEmpresa()
    {
        // Añadir el Global Scope para filtrar por empresa_id
        static::addGlobalScope('empresa', function (Builder $builder) {
            if (session()->has('empresa_id')) {
                // Si la empresa activa es la Maestra (SuperAdmin), no aplicamos filtro para ver todo.
                // Si la empresa activa es CUALQUIER OTRA (incluyendo cuando el SuperAdmin se "muda" a otra), filtramos.
                if (session('empresa_id') === '1CIX00000001') {
                    return;
                }
                $builder->where('empresa_id', session('empresa_id'));
            }
        });

        // Asignar automáticamente el empresa_id al crear nuevos registros
        static::creating(function ($model) {
            if (session()->has('empresa_id') && empty($model->empresa_id)) {
                $model->empresa_id = session('empresa_id');
            }
        });
    }

    /**
     * Relationship with Empresa.
     */
    public function empresa()
    {
        return $this->belongsTo(Empresa::class , 'empresa_id', 'id');
    }
}
