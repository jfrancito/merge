

<div class="container-fluid ordenpedido">

    <!-- HEADER -->
    <div class="panel panel-default">
        <div class="panel-heading header-principal">
            COTIZACION ORDEN PEDIDO
        </div>

        <div class="panel-body">
          <div class="panel panel-default filtros-box">
                <div class="panel-body">
                    <div class="row">

                        <div class="col-md-5">
                            <label>Empresa</label>
                            {!! Form::select('empresa_id', $combo_empresa, $empresa_id,
                                ['class'=>'select2 form-control','id'=>'empresa_id']) !!}
                        </div>

                        <div class="col-md-3">
                            <label>Año</label>
                            {!! Form::select('anio_pedido', $combo_anio, $anio_pedido,
                                ['class'=>'select2 form-control','id'=>'anio_pedido']) !!}
                        </div>

                        <div class="col-md-3">
                            <label>Periodo</label>
                            {!! Form::select('mes_pedido', $combo_mes, $mes_pedido,
                                ['class'=>'select2 form-control','id'=>'mes_pedido']) !!}
                        </div>



                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
<style>
    
    .btn-accion-consolidado-general {
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