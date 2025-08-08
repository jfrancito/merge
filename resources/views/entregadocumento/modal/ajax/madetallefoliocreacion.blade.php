<div class="modal-header" style="padding: 12px 20px;">
	<button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
	<div class="col-xs-12">
		<h5 class="modal-title" style="font-size: 1.2em;">
			LISTA DE FOLIOS PENDIENTES
		</h5>
	</div>
</div>
<div class="modal-body">

    <div class="panel panel-default">
      <div class="tab-container">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#foliopendiente" data-toggle="tab">FOLIOS PENDIENTES</a></li>
          <li><a href="#crearfolios" data-toggle="tab">CREAR FOLIOS</a></li>
          <li class="disabled"><a href="#detallefolios" data-toggle="tab">DETALLE DE FOLIOS</a></li>
          <li class="disabled"><a href="#guardarfolio" data-toggle="tab">GUARDAR</a></li>

        </ul>
        <div class="tab-content">
          <div id="foliopendiente" class="tab-pane active cont">
              <div class="scroll_text scroll_text_heigth_aler" style = "padding: 0px !important;">
                  <table  class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
                    <thead>
                      <tr>
                        <th>DETALLE</th>

                        <th>OPCION</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($listadatos as $index => $item)
                        <tr>
                          <td class="cell-detail sorting_1" style="position: relative;">
                            <span><b>FOLIO: </b> {{$item->FOLIO}}  </span>
                            <span><b>CANTIDAD  :</b> {{$item->CAN_FOLIO}}</span>
                            <span><b>BANCO : </b> {{$item->TXT_CATEGORIA_BANCO}}</span>
                            <span><b>MONEDA : </b> {{$item->TXT_CATEGORIA_MONEDA}}</span>
                            <span><b>GLOSA : </b> {{$item->TXT_GLOSA}}</span>
                            <span><b>OPERACION : </b> {{$item->OPERACION}}</span>
                          </td>
                          <td>
                              <div class="icon iconoentregable">
                                <span class="mdi mdi-select-all mdisel" data_folio='{{$item->FOLIO}}'></span>
                                <span class="mdi mdi-eye mdidet" data_folio='{{$item->FOLIO}}'></span>
                                <!-- <span class="mdi mdi-floppy mdisave" data_folio='{{$item->FOLIO}}' data_glosa='{{$item->TXT_GLOSA}}'></span> -->
                                <span class="mdi mdi-delete mdiex" data_folio='{{$item->FOLIO}}'></span>
                              </div>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
              </div>
          </div>
          <div id="crearfolios" class="tab-pane cont">
            <form method="POST" action="{{ url('/crear-folio-entregable/'.$idopcion) }}">
                  {{ csrf_field() }}
                    <div class="col-md-12">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                              <div class="form-group">
                                <label class="col-sm-12 control-label labelleft negrita" >Banco :</label>
                                <div class="col-sm-12 abajocaja" >
                                  {!! Form::select( 'banco_id', $combobancos, $banco_id,
                                                    [
                                                      'class'       => 'select2 form-control control input-xs combo' ,
                                                      'id'          => 'banco_id',
                                                      'data-aw'     => '1',
                                                      'required'    => '',
                                                    ]) !!}
                                </div>
                              </div>
                        </div><br>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                              <div class="form-group">
                                <label class="col-sm-12 control-label labelleft negrita" >Moneda (*):</label>
                                <div class="col-sm-12 abajocaja" >
                                  {!! Form::select( 'moneda_id', $combo_moneda, $defecto_moneda,
                                                    [
                                                      'class'       => 'select3 form-control control input-xs combo' ,
                                                      'id'          => 'moneda_id',
                                                      'data-aw'     => '1',
                                                      'required'    => '',
                                                    ]) !!}
                                </div>
                              </div>
                        </div>



                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                          <div class="form-group">
                            <label class="col-sm-12 control-label labelleft negrita" >GLOSA :</label>
                            <div class="col-sm-12">
                                <input  type="text"
                                        id="glosa" name='glosa'
                                        value=""
                                        placeholder="Glosa"
                                        required=""
                                        autocomplete="off" class="form-control input-sm importe control_caracteres" data-aw="2"/>
                            </div>
                          </div>
                        </div>
                      </div><br>
                      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: right;margin-top: 13px;margin-bottom: 13px;">
                        <button type="submit" data-dismiss="modal" class="btn btn-success btn-guardar-configuracion">Guardar</button>
                      </div>


            </form>
          </div>
          <div id="detallefolios" class="tab-pane detalle_folio">
            @include('entregadocumento.modal.ajax.mdetallefolio')
          </div>

          <div id="guardarfolio" class="tab-pane cont">
            <form method="POST" action="{{ url('/guardar-folio-entregable/'.$idopcion) }}">
                  {{ csrf_field() }}
                    <div class="col-md-12">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                          <div class="form-group">
                            <label class="col-sm-12 control-label labelleft negrita" >FOLIO :</label>
                            <div class="col-sm-12">
                                <input  type="text"
                                        id="folio" name='folio'
                                        value=""
                                        placeholder="Folio"
                                        required=""
                                        autocomplete="off" class="form-control input-sm importe" data-aw="2" readonly/>
                            </div>
                          </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                          <div class="form-group">
                            <label class="col-sm-12 control-label labelleft negrita" >BANCO :</label>
                            <div class="col-sm-12">
                                <input  type="text"
                                        id="banco" name='banco'
                                        value=""
                                        placeholder="Banco"
                                        required=""
                                        autocomplete="off" class="form-control input-sm importe" data-aw="2" readonly/>
                            </div>
                          </div>
                        </div>


                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                          <div class="form-group">
                            <label class="col-sm-12 control-label labelleft negrita" >CANTIDAD DOCUMENTOS :</label>
                            <div class="col-sm-12">
                                <input  type="text"
                                        id="cantidad" name='cantidad'
                                        value=""
                                        placeholder="cantidad"
                                        required=""
                                        autocomplete="off" class="form-control input-sm importe" data-aw="2" readonly/>
                            </div>
                          </div>
                        </div>



                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                          <div class="form-group">
                            <label class="col-sm-12 control-label labelleft negrita" >GLOSA :</label>
                            <div class="col-sm-12">
                                <input  type="text"
                                        id="glosa_g" name='glosa_g'
                                        value=""
                                        placeholder="Glosa"
                                        required=""
                                        autocomplete="off" class="form-control input-sm importe" data-aw="2"/>
                            </div>
                          </div>
                        </div>
                      </div><br>
                      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: right;margin-top: 13px;margin-bottom: 13px;">
                        <button type="submit" data-dismiss="modal" class="btn btn-success btn-guardar-configuracion">Guardar</button>
                      </div>


            </form>
          </div>

        </div>
      </div>
    </div>








</div>
<div class="modal-footer">
	<button type="button" data-dismiss="modal" class="btn btn-default btn-space modal-close">Cerrar</button>
</div>
