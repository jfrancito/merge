<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Traits\BelongsToEmpresa;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, BelongsToEmpresa;

    protected $table = 'users';
    public $timestamps = false;

    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';



    public function rol()
    {
        return $this->belongsTo('App\Models\Rol', 'rol_id', 'id');
    }

    public function series()
    {
        return $this->belongsToMany(Serie::class, 'usuario_series', 'usuario_id', 'serie_id')
                    ->wherePivot('activo', 1);
    }



}
