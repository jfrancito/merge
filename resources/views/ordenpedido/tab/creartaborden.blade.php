<div class="panel panel-default panel-table">

    <!-- ================= HEADER ORDEN ================= -->
    <div class="panel panel-default panel-contrast">
        <div class="panel-heading" style="background:#1d3a6d;color:#fff;">
            ORDEN DE PEDIDO
        </div>
    </div>

    <!-- ================= BODY ORDEN ================= -->
    <div class="panel-body" style="padding:10px">

        <input type="hidden" id="orden_pedido_id" value=""/>

        <!-- FILA 1 -->
        <div class="row form-row">
            <div class="col-md-6">
                <div class="row">
                    <label class="col-md-4 control-label label-sm text-center negrita">
                        N° PEDIDO <span class="obligatorio">(*)</span>
                    </label>
                    <div class="col-md-8">
                        <input type="text"
                               id="nro_pedido"
                               class="form-control text-uppercase"
                               value="{{ $nro_pedido }}"
                               readonly>

                        <input type="hidden"
                               id="id_pedido"
                               name="id_pedido"
                               value="">
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="row">
                    <label class="col-md-4 control-label label-sm text-center negrita">
                        ESTADO <span class="obligatorio">(*)</span>
                    </label>
                    <div class="col-md-8">
                         <input type="text"
                               class="form-control control text-uppercase"
                               value="{{ $estadosMerge[$estado_merge] ?? '' }}"
                               readonly>
                        <input type="hidden"
                               id="cod_estado"
                               name="cod_estado"
                               value="{{ $estado_merge }}">
                    </div>
                </div>
            </div>
        </div>

        <!-- FILA 2 -->
        <div class="row form-row">
            <div class="col-md-6">
                <div class="row">
                    <label class="col-md-4 control-label label-sm text-center negrita">
                        FECHA <span class="obligatorio">(*)</span>
                    </label>
                    <div class="col-md-8">
                       <input type="date"
       id="fec_pedido"
       name="fec_pedido"
       class="form-control control"
       style="height:38px"
       value="{{ date('Y-m-d') }}"
          readonly>

                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="row">
                    <label class="col-md-4 control-label label-sm text-center negrita">
                        REALIZADO POR <span class="obligatorio">(*)</span>
                    </label>
                    <div class="col-md-8">
                        <input type="text"
                               class="form-control control text-uppercase"
                               value="{{ strtoupper($listasolicita[$usuario_solicita] ?? '') }}"
                               readonly>
                        <input type="hidden"
                               id="cod_trabajador_solicita"
                               name="cod_trabajador_solicita"
                               value="{{ $usuario_solicita }}">
                    </div>
                </div>
            </div>
        </div>

        <!-- FILA 3 -->
        <div class="row form-row">
            <div class="col-md-6">
                <div class="row">
                    <label class="col-md-4 control-label label-sm text-center negrita">
                        AÑO <span class="obligatorio">(*)</span>
                    </label>
                    <div class="col-md-8">
                        {!! Form::select('cod_anio', $periodo_anio, '', [
                            'id' => 'cod_anio',
                            'class' => 'form-control control select2'
                        ]) !!}
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="row">
                    <label class="col-md-4 control-label label-sm text-center negrita">
                        AUTORIZADO POR <span class="obligatorio">(*)</span>
                    </label>
                    <div class="col-md-8">
                        {!! Form::select('cod_trabajador_autoriza', $usuario_autoriza, '', [
                            'id' => 'cod_trabajador_autoriza',
                            'class' => 'form-control control select2'
                        ]) !!}
                    </div>
                </div>
            </div>
        </div>

        <!-- FILA 4 -->
        <div class="row form-row">
            <div class="col-md-6">
                <div class="row">
                    <label class="col-md-4 control-label label-sm text-center negrita">
                        MES <span class="obligatorio">(*)</span>
                    </label>
                    <div class="col-md-8">
                     {{--  {!! Form::select('cod_periodo', ['' => 'Seleccione Mes'], '', [
                                'id' => 'cod_periodo',
                                'class' => 'form-control control select2'
                            ]) !!}  --}} 

                          {!! Form::select('cod_periodo', $periodo_mes, '', [
                            'id' => 'cod_periodo',
                            'class' => 'form-control control select2'
                        ]) !!}

                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="row">
                    <label class="col-md-4 control-label label-sm text-center negrita">
                        APROBADO GERENCIA <span class="obligatorio">(*)</span>
                    </label>
                    <div class="col-md-8">
                        {!! Form::select('cod_trabajador_aprueba_ger', $usuario_aprueba_ger, '', [
                            'id' => 'cod_trabajador_aprueba_ger',
                            'class' => 'form-control control select2'
                        ]) !!}

                    </div>
                </div>
            </div>
        </div>

        <!-- FILA 5 -->
        <div class="row form-row">
            <div class="col-md-6">
                <div class="row">
                    <label class="col-md-4 control-label label-sm text-center negrita">
                        EMPRESA <span class="obligatorio">(*)</span>
                    </label>
                    <div class="col-md-8">
                        <input type="text"
                               class="form-control control"
                               value="{{ $listaempresa[$empresa] ?? '' }}"
                               readonly>
                        <input type="hidden"
                               id="cod_empr"
                               name="cod_empr"
                               value="{{ $empresa }}">
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="row">
                    <label class="col-md-4 control-label label-sm text-center negrita">
                        APROBADO ADMIN <span class="obligatorio">(*)</span>
                    </label>
                    <div class="col-md-8">
                       {!! Form::select('cod_trabajador_aprueba_adm', $usuario_aprueba_adm, '', [
                            'id' => 'cod_trabajador_aprueba_adm',
                            'class' => 'form-control control select2'
                        ]) !!}

                    </div>
                </div>
            </div>
        </div>

        <!-- FILA 6 -->
        <div class="row form-row">
            <div class="col-md-6">
                <div class="row">
                    <label class="col-md-4 control-label label-sm text-center negrita">
                        SEDE <span class="obligatorio">(*)</span>
                    </label>
                    <div class="col-md-8">
                        <input type="text"
                               class="form-control control"
                               value="{{ $nom_centro }}"
                               readonly>
                        <input type="hidden"
                               id="cod_centro"
                               name="cod_centro"
                               value="{{ $cod_centro }}">
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="row">
                    <label class="col-md-4 control-label label-sm text-center negrita">
                        OBSERVACIÓN <span class="obligatorio">(*)</span>
                    </label>
                    <div class="col-md-8">
                        <textarea id="txt_glosa"
                                  name="txt_glosa"
                                  class="form-control"
                                  rows="2"
                                  required
                                  placeholder="Observación"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- FILA 7 -->
        <div class="row form-row">
            <div class="col-md-6">
                <div class="row">
                    <label class="col-md-4 control-label label-sm text-center negrita">
                        TIPO <span class="obligatorio">(*)</span>
                    </label>
                    <div class="col-md-8">
                        {!! Form::select('cod_tipo_pedido', $listatipopedido, '', [
                            'id' => 'cod_tipo_pedido',
                            'class' => 'form-control control select2'
                        ]) !!}

                    </div>
                </div>
            </div>
        </div>

        <!-- FILA 8 -->
      
    </div><!-- FIN panel-body ORDEN -->

    <!-- ================= HEADER DETALLE ================= -->
    <div class="panel panel-default panel-contrast">
        <div class="panel-heading" style="background:#1d3a6d;color:#fff;">
            DETALLE ORDEN PEDIDO
        </div>
    </div>

    <!-- ================= BODY DETALLE ================= -->
    <div class="panel-body" style="padding:10px">

        <div class="row mb-3 align-items-end">
            <div class="col-md-5">
                <label class="label-sm negrita">
                    PRODUCTO <span class="obligatorio">(*)</span>
                </label>
                <select id="cod_producto" class="form-control select2 select2-lg">
                        <option value="">Buscar producto...</option>
                        @foreach($producto as $prd)
                         <option value="{{ $prd->COD_PRODUCTO }}"
                                data-nombre="{{ $prd->NOM_PRODUCTO }}"
                                data-unidad="{{ $prd->UNIDAD }}"
                                data-codcategoria="{{ $prd->COD_UNIDAD }}">
                            {{ $prd->COD_PRODUCTO }} - {{ $prd->NOM_PRODUCTO }}
                        </option>

                        @endforeach
                    </select>
            </div>

              <div class="col-md-2">
                    <label class="label-sm negrita">
                        MEDIDA <span class="obligatorio">(*)</span>
                    </label>
                    <input type="text"
                           id="unidad"
                           class="form-control text-center"
                           readonly>
             </div>


            <div class="col-md-1">
                <label class="label-sm negrita">
                    CANT. <span class="obligatorio">(*)</span>
                </label>
                  <input type="number"
                   id="cantidad"
                   class="form-control cantidad-input"
                   min="0"
                   step="1"
                   oninput="this.value = Math.max(0, this.value)">
            </div>

            <div class="col-md-4">
                <label class="label-sm negrita">
                    OBSERVACIÓN
                </label>
                <input type="text" id="txt_observacion"
                       class="form-control" placeholder="Opcional">
            </div>

            <div class="col-md-6 text-end mt-2">
                <button id="agregar_producto" class="btn btn-success btn-sm">
                    <i class="fa fa-plus"></i> Agregar Producto
                </button>
                <button id="eliminar_producto" class="btn btn-danger btn-sm">
                    <i class="fa fa-trash"></i> Eliminar Producto
                </button>
               <button id="asignarordenpedido" class="btn btn-primary btn-sm">
                    <i class="fa fa-save"></i> Guardar Pedido
                </button>
            </div>
        </div>

        <hr style="border-top: 2px solid transparent; margin: 10px 0;">


        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="tabla_detalle_pedido">
                <thead>
                    <tr>
                        <th class=" text-center">#</th>
                        <th class=" text-center">CÓDIGO</th>
                        <th class=" text-center">PRODUCTO</th>
                        <th class=" text-center">UNIDAD</th>
                        <th class=" text-center">CANTIDAD</th>
                        <th class=" text-center">OBSERVACIÓN</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

    </div><!-- FIN panel-body DETALLE -->

</div><!-- FIN panel-table -->

<style>
.form-row{
    margin-bottom:4px;
}

.label-sm{
    font-weight:bold;
    font-size:12px;
    position:relative;
    padding-right:12px;
    line-height:34px;   
}

.cantidad-input{
    text-align:center;
    font-weight:600;
    font-size:14px;
}

.label-sm::after{
    content:":";
    position:absolute;
    right:0;
    top:50%;
    transform:translateY(-50%);
}

.panel-heading{
    background:#003366;
    color:#fff;
    font-size:14px;
    padding:6px;
}

.select2-container--default .select2-selection--single{
    height:38px;
    border-radius:6px;
    border:1px solid #dce1e7;
}

.select2-selection__rendered{
    line-height:38px !important;
}

.select2-selection__arrow{
    height:36px !important;
}

.form-control{
    border-radius:6px;
    border:1px solid #dce1e7;
    box-shadow:none;
    transition:.2s;
}

.form-control:focus{
    border-color:#4facfe;
    box-shadow:0 0 0 2px rgba(79,172,254,.15);
}

.btn{
    border-radius:6px;
    padding:6px 14px;
    font-weight:500;
}

.table{
    font-size:13px;
}

.table thead th{
    background:#f5f7fa;
    font-weight:600;
    color:#2c3e50;
}

.table tbody tr:hover{
    background:#f0f6ff;
}

.fila-seleccionada{
    background:#e3f2fd !important;
    cursor:pointer;
}


</style>

