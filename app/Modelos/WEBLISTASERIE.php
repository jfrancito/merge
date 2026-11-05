<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class WEBLISTASERIE extends Model
{
    protected $table = 'WEB.LISTASERIE';
    public $timestamps = false;

    public $incrementing = false;
    public $keyType = 'string';
}

if (!class_exists('App\Modelos\WEBListaSerie')) {
    class_alias('App\Modelos\WEBLISTASERIE', 'App\Modelos\WEBListaSerie');
}
