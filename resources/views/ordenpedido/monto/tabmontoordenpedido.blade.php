<div class="container-fluid ordenpedido">
    <!-- HEADER -->
    <div class="panel panel-default">
        <div class="panel-heading header-principal">
            CONFIGURAR MONTO ORDEN DE PEDIDO
        </div>

        <div class="panel-body">
            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">

            <div class="panel panel-default filtros-box">
                <div class="panel-body">

                    <div class="row align-items-end">

                        <!-- Nombre -->
                        <div class="col-md-4">
                            <label>Nombre Configuración</label>
                            {!! Form::select('nombre_config', $combo1, $nombre_config,
                                [
                                    'class' => 'select2 form-control',
                                    'id' => 'nombre_config',
                                    'disabled' => 'disabled'
                                ]) !!}
                        </div>

                        <!-- Monto -->
                        <div class="col-md-2">
                            <label class="form-label-custom">Monto</label>
                            <input type="number"
                                   name="monto"
                                   id="monto"
                                   class="form-control text-center"
                                   min="0"
                                   step="1"
                                   oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                   placeholder="Ingrese monto">
                        </div>

                        <!-- Botón -->
                        <div class="col-md-4">
                            <label style="margin-top: 40px;"></label>
                            <button class="btn btn-success btn-accion-consolidado w-100"
                                    id="btn_modificar_monto">
                                <i class="mdi mdi-pencil"></i>
                                Modificar
                            </button>
                        </div>

                    </div>

                </div>
            </div>

            <!-- TABLA -->
            <div class="table-responsive listajax mt-3">
                @include('ordenpedido.monto.alistamontoordenpedido')
            </div>

        </div>
    </div>
</div>

<style>
/* HEADER */
.header-principal {
    background: #1d3a6d;
    color: #fff;
    font-size: 16px;
    font-weight: 600;
    padding: 10px 15px;
}

/* CONTENEDOR FILTROS */
.filtros-box {
    background: #f9fbfd;
    border: 1px solid #e1e6ef;
    border-radius: 8px;
}

.filtros-box label {
    font-size: 12px;
    font-weight: 600;
    color: #34495e;
}

/* SELECT2 */
.select2-container--default .select2-selection--single {
    height: 42px;
    border-radius: 8px;
}

/* INPUT */
.form-control {
    border-radius: 8px;
    height: 42px;
    border: 1px solid #dce3ec;
    transition: all 0.2s ease-in-out;
}

.form-control:focus {
    border-color: #1d3a6d;
    box-shadow: 0 0 0 0.15rem rgba(29, 58, 109, 0.15);
}

/* LABEL MONTO */
.form-label-custom {
    font-size: 12px;
    font-weight: 600;
    color: #4a5568;
}

/* BOTÓN */
.btn-accion-consolidado {
    border-radius: 6px;
    font-weight: 600;
    height: 42px;
}
</style>