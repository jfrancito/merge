<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class WEBAsiento extends Model
{
    protected $table = 'WEB.asientos';
    public $timestamps = false;
    protected $primaryKey = 'COD_ASIENTO';
    public $incrementing = false;
    public $keyType = 'string';


    public function periodo()
    {
        return $this->belongsTo('App\Modelos\CONPeriodo', 'COD_PERIODO', 'COD_PERIODO');
    }

    public function moneda()
    {
        return $this->belongsTo('App\Modelos\CMPCategoria', 'COD_CATEGORIA_MONEDA', 'COD_CATEGORIA');
    }

    public function viewmigrarcompra()
    {
        return $this->belongsTo('App\Modelos\WEBViewMigrarCompras', 'TXT_REFERENCIA', 'COD_DOCUMENTO_CTBLE');
    }


    public function tipo_documento()
    {
        return $this->belongsTo('App\Modelos\CMPCategoria', 'COD_CATEGORIA_TIPO_DOCUMENTO', 'COD_CATEGORIA');
    }

    public function tipo_documento_ref()
    {
        return $this->belongsTo('App\Modelos\CMPCategoria', 'COD_CATEGORIA_TIPO_DOCUMENTO_REF', 'COD_CATEGORIA');
    }

    public function asientomovimiento()
    {
        return $this->hasMany('App\Modelos\WEBAsientoMovimiento', 'COD_ASIENTO', 'COD_ASIENTO');
    }

    public function empresa()
    {
        return $this->belongsTo('App\Modelos\STDEmpresa', 'COD_EMPR_CLI', 'COD_EMPR');
    }

    public function scopeTipoDocumento($query, $tipodocumento)
    {
        if (trim($tipodocumento) != '') {
            $query->where('WEB.asientos.COD_CATEGORIA_TIPO_DOCUMENTO', 'like', '%' . $tipodocumento . '%');
        }
    }


    public function scopeNroSerie($query, $serie)
    {
        if (trim($serie) != '') {
            $query->where('WEB.asientos.NRO_SERIE', 'like', '%' . $serie . '%');
        }
    }


    public function scopeRazonSocial($query, $razonsocial)
    {
        if (trim($razonsocial) != '') {
            $query->where('WEB.asientos.TXT_EMPR_CLI', 'like', '%' . $razonsocial . '%');
        }
    }

    public function scopeNroDocumento($query, $documento)
    {
        if (trim($documento) != '') {
            $query->where('WEB.asientos.NRO_DOC', 'like', '%' . $documento . '%');
        }
    }

    public function scopeTipoAsiento($query, $tipo_asiento_id)
    {
        if (trim($tipo_asiento_id) != '') {
            $query->where('WEB.asientos.COD_CATEGORIA_TIPO_ASIENTO', '=', $tipo_asiento_id);
        }
    }

    public function scopePeriodo($query, $periodo_id)
    {
        if (trim($periodo_id) != '') {
            $query->where('CON.PERIODO.COD_PERIODO', '=', $periodo_id);
        }
    }

    public function scopeOrdFecha($query, $tipoasiento)
    {
        if ($tipoasiento == 'TAS0000000000004') {
            $query->orderBy('WEB.asientos.FEC_USUARIO_MODIF_AUD', 'ASC');
        } else {
            $query->orderBy('WEB.asientos.CODIGO_CONTABLE', 'ASC');
        }
    }

    public function scopeMigracionNava($query, $ind_migracion)
    {

        if ($ind_migracion == 1) {
            $query->where('WEB.asientos.IND_MIGRACION_NAVASOFT', '=', $ind_migracion);
        } else {
            if ($ind_migracion == 0) {

                $query->where(function ($xx) {
                    $xx->whereNull('WEB.asientos.IND_MIGRACION_NAVASOFT')
                        ->orWhere('WEB.asientos.IND_MIGRACION_NAVASOFT', '=', 0);
                });

            }
        }

    }

    public function scopeTransGratuita($query, $trangratuita)
    {
        if (trim($trangratuita) != 'TODOS') {
            $query->where('IND_GRATUITO', '=', $trangratuita);
        }
    }


}
