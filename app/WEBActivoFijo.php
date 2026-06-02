<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WEBActivoFijo extends Model
{
    protected $table = 'WEB.activosfijos';
    public $timestamps = false;
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id', 'item_ple', 'nombre', 'cantidad', 'factura', 'placa', 'marca', 'modelo', 'numero_serie', 
        'observacion', 'estado', 'origen', 'tipo_activo', 'activo_principal', 'modalidad_adquisicion', 
        'estado_conservacion', 'fecha_registro', 'fecha_emision', 'base_de_calculo', 
        'saldo_inicio_depreciacion_acumulada', 'fecha_inicio_depreciacion', 'estado_depreciacion', 
        'depreciacion_acumulada', 'ultima_fecha_depreciacion', 'fecha_baja', 'cod_producto', 
        'categoria_activo_fijo_id', 'catnombre', 'cuenta_debe', 'cuenta_haber', 'cod_documento_ctble', 
        'cod_tabla', 'cod_tabla_asoc', 'cod_empresa', 'ruc_empresa', 'proveedor', 'cod_centro', 
        'usuario_id', 'fechacreacion', 'fecha_modificacion', 'COD_ASIGNA', 'CAD_ASIGNA', 'COD_RECIBE', 
        'CAD_RECIBE', 'descripcion', 'proceso', 'centro_costo', 'cuenta', 'ruc', 'centro_data', 
        'saldo_inicial', 'adiciones', 'baja_ejercicios_anteriores', 'bajas', 'valor_residual', 
        'fecha_adquision', 'fecha_inicio', 'Dias_depreciar_nuevo_mes', 
        'saldo_inicio_depreciacion_acumulada_data', 'depreciacion_data', 'depreciacion_acumulada_data', 
        'depreciacion_por_hora', 'saldo_depreciar'
    ];
}
