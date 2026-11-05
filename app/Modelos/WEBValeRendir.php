<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class WEBValeRendir extends Model
{
    protected $table = 'WEB.VALE_RENDIR';
    public $timestamps=false;

    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

}