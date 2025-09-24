<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class WEBValeRendirReembolso extends Model
{
    protected $table = 'WEB.VALE_RENDIR_REEMBOLSO';
    public $timestamps=false;

    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

}