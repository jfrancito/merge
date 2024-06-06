<div class="modal-header background-amarillo" style = "padding: 12px !important;color: #000;">
  <button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
  <h3 class="modal-title">
    <strong>
      DOCUMENTOS MERGE
    </strong>
  </h3>
</div>

<div class="modal-body modal-pedido-poc" style = "padding: 0px !important;">
  <div class="scroll_text scroll_text_heigth_poc" style = "padding: 0px !important;"> 
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="tab-container">
          <ul class="nav nav-tabs">
            <li class="seltab active" data_tab='ocen'>
              <a href="#losiris" data-toggle="tab">DOCUMENTOS</a>
            </li>
          </ul>
          <div class="tab-content" style = "padding: 0px !important;">
            <div id="losiris" class="tab-pane active cont">


              <table id="despacholocen" class="table table table-hover table-fw-widget dt-responsive nowrap lista_tabla_merge" style='width: 100%;'>
                <thead>
                  <tr>
                      <th>SERIE - NUMERO</th>
                      <th>FECHA</th>
                      <th>FORMA PAGO</th>
                      <th>RUC</th>
                      <th>PROVEEDOR</th>
                      <th>TOTAL</th>
                    <th>Sel</th>

                  </tr>
                </thead>
                <tbody>
                    @foreach($listadocumentos as $index => $item)

                      <tr
                        class='filaoc'
                        data_documento_id="{{$item->ID_DOCUMENTO}}"
                      >
                        <td>
                          {{$item->SERIE}} - {{$item->NUMERO}}
                        </td>
                        <td>{{date_format(date_create($item->FEC_VENTA), 'd-m-Y')}}</td>
                        <td>{{$item->FORMA_PAGO}}</td>
                        <td>{{$item->RUC_PROVEEDOR}}</td>
                        <td>{{$item->RZ_PROVEEDOR}}</td>
                        <td>{{$item->TOTAL_VENTA_ORIG}}</td>
                        <td>
                          <div class="text-center be-checkbox be-checkbox-sm has-primary">
                            <input  
                              type="checkbox"
                              class="{{$item->ID_DOCUMENTO}} input_asignar_oc"
                              id="{{$item->ID_DOCUMENTO}}" >

                            <label  for="{{$item->ID_DOCUMENTO}}"
                                  data-atr = "ver"
                                  class = "checkbox checkbox_asignar_oc"                    
                                  name="{{$item->ID_DOCUMENTO}}"
                            ></label>
                          </div>
                        </td>
                      </tr>  
                    @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="modal-footer">
  <button type="button" data-dismiss="modal" class="btn btn-default modal-close">Cancelar</button>
  <button type="submit" data-dismiss="modal" class="btn btn-success" id="agregardocumentosmerge">Agregar Documentos</button>
</div>

@if(isset($ajax))
  <script type="text/javascript">
    $(document).ready(function(){
       App.dataTables();
    });
  </script> 
@endif