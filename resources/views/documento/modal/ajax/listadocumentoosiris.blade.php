<div class="modal-header" style = "padding: 12px !important;background: #1d3a6d;">
  <button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
  <h3 class="modal-title">
    <strong>
      DOCUMENTOS OSIRIS
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

              <table id="despacholocen" class="table table table-hover table-fw-widget dt-responsive nowrap lista_tabla_osiris" style='width: 100%;'>
                <thead>
                  <tr> 
                    <th>Documento</th>
                    <th>Fecha Emision</th>
                    <th>Emisor</th>
                    <th>Moneda</th>
                    <th>Subtotal</th>
                    <th>Impuesto</th>
                    <th>Total</th>

                    <th>Sel</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach($listadocumentos as $index => $item)

                      <tr
                        class='filaoc'
                        data_documento_id="{{$item->COD_DOCUMENTO_CTBLE}}"
                      >
                        <td>
                          {{$item->NRO_SERIE}} - {{$item->NRO_DOC}}
                        </td>
                        <td>{{date_format(date_create($item->FEC_EMISION), 'd-m-Y')}}</td>
                        <td>{{$item->TXT_EMPR_EMISOR}}</td>

                        <td>{{$item->TXT_CATEGORIA_MONEDA}}</td>

                        <td>{{$item->CAN_SUB_TOTAL}}</td>
                        <td>{{$item->CAN_IMPUESTO_VTA}}</td>
                        <td>{{$item->CAN_TOTAL}}</td>
                        <td>
                          <div class="text-center be-checkbox be-checkbox-sm has-primary">
                            <input  
                              type="checkbox"
                              class="{{$item->COD_DOCUMENTO_CTBLE}} input_asignar_oc"
                              id="{{$item->COD_DOCUMENTO_CTBLE}}" >

                            <label  for="{{$item->COD_DOCUMENTO_CTBLE}}"
                                  data-atr = "ver"
                                  class = "checkbox checkbox_asignar_oc"                    
                                  name="{{$item->COD_DOCUMENTO_CTBLE}}"
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
  <button type="submit" data-dismiss="modal" class="btn btn-success" id="agregardocumentos">Agregar Documentos</button>
</div>

@if(isset($ajax))
  <script type="text/javascript">
    $(document).ready(function(){
       App.dataTables();
    });
  </script> 
@endif