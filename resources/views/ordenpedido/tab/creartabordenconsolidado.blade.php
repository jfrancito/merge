<div class="container-fluid ordenpedido">

    <!-- HEADER -->
    <div class="panel panel-default">
        <div class="panel-heading header-principal">
            ORDEN PEDIDO CONSOLIDADO
        </div>

        <div class="panel-body">
          <div class="panel panel-default filtros-box">
                <div class="panel-body">
                    <div class="row">

                        <div class="col-md-4">
                            <label>Empresa</label>
                            {!! Form::select('empresa_id', $combo_empresa, $empresa_id,
                                ['class'=>'select2 form-control','id'=>'empresa_id']) !!}
                        </div>

                        <div class="col-md-2">
                            <label>Centro</label>
                            {!! Form::select('centro_id', $combo_centro, $centro_id,
                                ['class'=>'select2 form-control','id'=>'centro_id']) !!}
                        </div>

                        <div class="col-md-2">
                            <label>Año</label>
                            {!! Form::select('anio_pedido', $combo_anio, $anio_pedido,
                                ['class'=>'select2 form-control','id'=>'anio_pedido']) !!}
                        </div>

                        <div class="col-md-3">
                            <label>Periodo</label>
                            {!! Form::select('mes_pedido', $combo_mes, $mes_pedido,
                                ['class'=>'select2 form-control','id'=>'mes_pedido']) !!}
                        </div>

                        <div class="col-md-1 d-flex align-items-end">
                            <button class="btn btn-primary buscarpedidoconsolidado" style="margin-top:17px;">
                                <i class="mdi mdi-search"></i> Buscar
                            </button>
                        </div>
                    </div>
                </div>
            </div>


            <!-- TABLA -->
            <div class="table-responsive listajax mt-3">
              
            </div>

            <div class="text-right mt-1">
                <button class="btn btn-success btn-accion-consolidado btn-consolidar">
                    <i class="mdi mdi-check"></i> Consolidar
                </button>
                <button class="btn btn-primary btn-accion-consolidado btn-guardar-consolidado">
                    <i class="fa fa-save"></i> Guardar
                </button>
            </div>



               @include('ordenpedido.consolidado.listaordenconsolidado')

               <!-- CONTENEDOR NUEVO: DETALLE DEL PRODUCTO CONSOLIDADO (EN TABLA INFERIOR) -->
                <div id="contenedor-detalle-producto-consolidado-general" style="display: none; margin-top: 25px;">
                    
                    <div style="position: relative; margin-bottom: 15px;">
                        <h4 class="text-center" style="font-weight: bold; margin: 0; text-transform: uppercase;">
                            <i class="mdi mdi-receipt"></i> DETALLE: <span id="titulo-producto-detalle-general" class="text-primary"></span>
                        </h4>
                        <div style="position: absolute; right: 0; top: 0;">
                            <button type="button" class="btn btn-xs btn-danger" onclick="$('#contenedor-detalle-producto-consolidado-general').slideUp();">
                                <i class="mdi mdi-close"></i> Cerrar
                            </button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover td-color-borde td-padding-7 display nowrap" id="tablaDetalleInferiorGeneral" cellspacing="0" width="100%">
                            <thead class="background-th-azul">
                                <tr>
                                    <th class="text-center">FECHA</th>
                                    <th class="text-center">NRO PEDIDO</th>
                                    <th class="text-center">AREA</th>
                                    <th class="text-center">GLOSA</th>
                                    <th class="text-center">CANTIDAD</th>
                                </tr>
                            </thead>
                            <tbody style="background: white;">
                                <!-- Se llena dinámicamente -->
                            </tbody>
                        </table>
                    </div>
                </div>
        </div>
    </div>

</div>
<style>
    
    .btn-accion-consolidado {
        width: 130px;
        border-radius: 6px;
        padding: 6px 0px;
        font-weight: 600;
        margin-left: 5px;
    }

    .header-principal{
    background:#1d3a6d;
    color:#fff;
    font-size:16px;
    font-weight:600;
    padding:10px 15px;
}

.titulo-seccion{
    margin:0;
    font-weight:600;
    color:#2c3e50;
}

.filtros-box{
    background:#f9fbfd;
    border:1px solid #e1e6ef;
    border-radius:8px;
}

.filtros-box label{
    font-size:12px;
    font-weight:600;
    color:#34495e;
}

.select2-container--default .select2-selection--single{
    height:38px;
    border-radius:6px;
}

.btn-primary{
    border-radius:6px;
    padding:6px 18px;
}

</style>