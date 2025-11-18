<div class="panel panel-default panel-table">
    <div class="panel panel-default panel-border-color panel-border-color-success">
        <div class="panel-heading">Solicitud de Vale Reembolso
        </div>
    </div>
    <div class="panel-body selectfiltro">


        <div class='filtrotabla row'>
            <div class="col-xs-12">

                <input type="hidden" id="vale_rendir_id" value=""/>

                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 cajareporte ind_producto">
                    <div class="form-group">
                        <label class="col-sm-12 control-label labelleft">Autoriza
                            :</label>
                        <div class="col-sm-12 abajocaja">
                            {!! Form::select('cliente_select', $listausuarios, $usuario_autoriza_predeterminado,
                               [
                                 'class'       => 'form-control control select2' ,
                                 'id'          => 'cliente_select',
                                 'data-aw'     => '1',
                                 'disabled'    => 'disabled', 
                               ])
                            !!}
                        </div>
                    </div>
                </div>

            {{--    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 cajareporte ind_producto">
                    <div class="form-group">
                        <label class="col-sm-12 control-label labelleft">Aprueba :</label>
                        <div class="col-sm-12 abajocaja">

                            {!! Form::select('cliente_select1', $listausuarios1, $usuario_aprueba_predeterminado,
                               [
                                 'class'       => 'form-control control select2',
                                 'id'          => 'cliente_select1',
                                 'data-aw'     => '1',
                                 'disabled'    => 'disabled', 
                               ])
                            !!}

                        </div>
                    </div>
                </div>  --}}

                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 cajareporte ind_producto">
                    <div class="form-group">
                        <label class="col-sm-12 control-label labelleft">Motivo :</label>
                        <div class="col-sm-12 abajocaja">

                            {!! Form::select('tipo_motivo', $listausuarios2, '',
                                   [
                                     'class'       => 'form-control control select2' ,
                                     'id'          => 'tipo_motivo',
                                     'data-aw'     => '1',
                                   ])
                            !!}
                        </div>
                    </div>
                </div>


                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 cajareporte ind_producto">
                    <div class="form-group">
                        <label class="col-sm-12 control-label labelleft">Moneda :</label>
                        <div class="col-sm-12 abajocaja">

                            {!! Form::select('cod_moneda', $listausuarios4, '',
                                   [
                                     'class'       => 'form-control control select2' ,
                                     'id'          => 'cod_moneda',
                                     'data-aw'     => '1',
                                   ])
                            !!}
                        </div>
                    </div>
                </div>


                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 cajareporte ind_producto">

                    <div class="form-group">
                        <label class="col-sm-12 control-label labelleft">Importe :</label>
                        <div class="col-sm-12 input-group xs-mb-15">

                            <input type="text"
                                   id="can_total_importe" name='' value="" placeholder="Importe"
                                   required=""
                                   autocomplete="off" class="form-control input-md dinero_masivo"
                                   data-aw="4"/>
                        </div>
                    </div>
                </div>


                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 cajareporte ind_producto">

                    <div class="form-group">
                        <label class="col-sm-12 control-label labelleft">Saldo :</label>
                        <div class="col-sm-12 input-group xs-mb-15">

                            <input type="text"
                                   id="can_total_saldo" name='can_total_saldo' value=""
                                   placeholder="Saldo"
                                   required=""
                                   autocomplete="off" class="form-control input-md dinero_masivo"
                                   data-aw="4"/>
                        </div>
                    </div>
                </div>


                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 cajareporte ind_producto">
                    <div class="form-group">
                        <label class="col-sm-12 control-label labelleft">Glosa :</label>
                        <div class="col-sm-12 input-group xs-mb-15">
                            <textarea id="txt_glosa" name="" placeholder="Glosa" required=""
                                      autocomplete="off" class="form-control custom-glosa-height"
                                      data-aw="4"></textarea>
                            <span class="input-group-btn">
                            <button id="asignarvalerendir" type="button" class="btn btn-primary ">
                                  <font style="vertical-align: inherit;"><font
                                              style="vertical-align: inherit;">Guardar</font></font>
                                </button>
                           </span>
                        </div>
                    </div>
                </div>

            </div>

            <div class="listadetalleajax"></div>

            <div class="ajaxvacio text-center fw-bold">
                COMPLETE LOS CAMPOS CORRECTAMENTE ...
            </div>

            <input type="text" id="vale_rendir_id" hidden>
            @include('valerendir.modal.detallerendir')

            <div id="vale_rendir_detalle" style="display: none;">


                <div class="panel-heading">Detalle a Rendir</div>

                <div class="row"
                     style="display: flex; align-items: center; gap: 15px; flex-wrap: wrap;">

                    <!-- Fecha Inicio -->
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 cajareporte ind_producto">
                        <label class="control-label labelleft">Fecha Inicio:</label>
                        <input type="datetime-local"
                               id="fecha_inicio"
                               name="fecha_inicio"
                               class="form-control control"
                               data-aw="1">
                    </div>


                    <!-- Fecha Fin -->
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 cajareporte ind_producto">

                        <label class="control-label labelleft">Fecha Fin:</label>
                        <input type="datetime-local"
                               id="fecha_fin"
                               name="fecha_fin"
                               class="form-control control"
                               data-aw="1">
                    </div>

                     <div class="col-md-3 col-lg-3">
                          <div class="form-group">
                            <label for="tipo_pago" class="control-label labelleft negrita">
                              DESTINO <span class="obligatorio">(*)</span> :
                            </label>
                             {!! Form::select('destino', $listausuarios3, '', [
                            'class'   => 'form-control control select2',
                            'id'      => 'destino',
                            'data-aw' => '1',
                        ]) !!}
                          </div>
                        </div>

                    <!-- Movilidad Propia -->
                    <div class="form-group"
                         style="display: flex; flex-direction: column; align-items: center;">
                        <label for="ind_propio" style="font-size: 13px;">Movilidad Propia:</label>
                        <input type="checkbox" id="ind_propio" name="ind_propio" value="1"
                               style="width: 18px; height: 18px;">
                    </div>

                    <!-- Movilidad Aérea -->
                    <div class="form-group"
                         style="display: flex; flex-direction: column; align-items: center;">
                        <label for="ind_aereo" style="font-size: 13px;">Pasaje Aéreo:</label>
                        <input type="checkbox" id="ind_aereo" name="ind_aereo" value="1"
                               style="width: 18px; height: 18px;">
                    </div>

                    <!-- Botón Agregar -->
                    <div class="form-group" style="margin-left: 30px;">
                        <input type="hidden" id="detalle_id" value=""/>
                        <button id="agregarImporteGasto" type="button"
                                class="btn btn-success rounded-circle btn-icon"
                                style="width: 30px; height: 30px;" title="Agregar">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>

                    <!-- Botón Ver Detalle -->
                   {{-- <div class="form-group">
                        <button type="button"
                                class="btn btn-primary verdetalleimportegastos-valerendir-reembolso"
                                title="Ver detalle de importes">
                            <i class="mdi mdi-eye mdi-24px"></i>
                        </button>
                    </div>--}}

                    <!-- Hidden Inputs -->
                    <input type="hidden" id="nom_centro" value="{{ $nom_centro }}">
                    <input type="hidden" id="importeDestinos"
                           value="{{ json_encode($importeDestinos) }}">
                </div>
                
                <div class="col-xs-12">
                    <div class='listacontratomasiva listajax reporteajax'>
                    </div>
                </div>
              @include('valerendirreembolso.ajax.listamodaldetalleregistroimportereembolso')

            </div>

            <div class="col-xs-12">
                <div class='listacontratomasiva listajax reporteajax'>
                </div>
            </div>
            <div class='listajax'>
                   @include('valerendirreembolso.ajax.listamodalvalerendirreembolso')

            </div>
        </div>
    </div>
</div>