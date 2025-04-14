<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class WEBListaPersonal extends Model
{
    protected $table = 'WEB.LISTAPERSONAL';
    public $timestamps=false;

    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

}
