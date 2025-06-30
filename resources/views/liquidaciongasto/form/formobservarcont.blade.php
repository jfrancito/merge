<div class="form-group">
  <label class="col-sm-3 control-label">TRABAJADOR:</label>
  <div class="col-sm-6">
  <input type="text" disabled class="form-control control input-sm" value="{{$liquidaciongastos->TXT_EMPRESA_TRABAJADOR}}">
  </div>
</div>
<div class="form-group">
  <label class="col-sm-3 control-label">CENTRO:</label>
  <div class="col-sm-6">
  <input type="text" disabled class="form-control control input-sm" value="{{ $liquidaciongastos->TXT_CENTRO }}">
  </div>
</div>

<div class="form-group">
  <label class="col-sm-3 control-label">PERIODO:</label>
  <div class="col-sm-6">
  <input type="text" disabled class="form-control control input-sm" value="{{ $liquidaciongastos->TXT_PERIODO }}">
  </div>
</div>

<div class="form-group">
  <label class="col-sm-3 control-label">FECHA EMISION:</label>
  <div class="col-sm-6">
  <input type="text" disabled class="form-control control input-sm" value="{{date_format(date_create($liquidaciongastos->FECHA_EMI), 'd/m/Y')}}">
  </div>
</div>


<div class="form-group">
  <label class="col-sm-3 control-label">Detalle Documento:</label>
  <div class="col-sm-6">

      <div>
          <table class="table table-condensed table-striped tablaobservacion">
            <thead>
              <tr>
                <th>FECHA EMISION</th>
                <th>DOCUMENTO</th>      
                <th>TIPO DOCUMENTO</th>       
                <th>PROVEEDOR</th>
                <th>TOTAL</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
                @foreach($tdetliquidaciongastos as $index => $item)
                <tr data_id="{{$item->ID_DOCUMENTO}}" data_item='{{$item->ITEM}}'>
                  <td>{{date_format(date_create($item->FECHA_EMISION), 'd/m/Y')}}</td>
                  <td>{{$item->SERIE}} - {{$item->NUMERO}} </td>
                  <td>{{$item->TXT_TIPODOCUMENTO}}</td>
                  <td>{{$item->TXT_EMPRESA_PROVEEDOR}}</td>                    
                  <td>{{$item->TOTAL}}</td>
                  <td>
                      <div class="text-center be-checkbox be-checkbox-sm has-primary">
                        <input  type="checkbox"
                          class="{{$item->ID_DOCUMENTO}}{{$item->ITEM}} input_asignar"
                          id="{{$item->ID_DOCUMENTO}}{{$item->ITEM}}" >
        
                        <label  for="{{$item->ID_DOCUMENTO}}{{$item->ITEM}}"
                              data-atr = "ver"
                              class = "checkbox checkbox_asignar"                    
                              name="{{$item->ID_DOCUMENTO}}{{$item->ITEM}}"
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


<div class="form-group">
  <label class="col-sm-3 control-label">Documentos Observados:</label>
  <div class="col-sm-6">

      <div>
          <table class="table table-condensed table-striped tablaobservacion">
            <thead>
              <tr>
                <th>FECHA EMISION</th>
                <th>DOCUMENTO</th>      
                <th>TIPO DOCUMENTO</th>       
                <th>PROVEEDOR</th>
                <th>TOTAL</th>
              </tr>
            </thead>
            <tbody>
                @foreach($tdetliquidaciongastosel as $index => $item)
                <tr>
                  <td>{{date_format(date_create($item->FECHA_EMISION), 'd/m/Y')}}</td>
                  <td>{{$item->SERIE}} - {{$item->NUMERO}} </td>
                  <td>{{$item->TXT_TIPODOCUMENTO}}</td>
                  <td>{{$item->TXT_EMPRESA_PROVEEDOR}}</td>                    
                  <td>{{$item->TOTAL}}</td>
                </tr>
                @endforeach
            </tbody>
          </table>
      </div>

  </div>
</div>







<div class="form-group">
  <label class="col-sm-3 control-label">Descripcion de Observacion<span class="obligatorio">(*)</span> :</label>
  <div class="col-sm-6">
        <textarea 
        name="descripcion"
        id = "descripcion"
        class="form-control input-sm validarmayusculas"
        rows="5" 
        cols="50"
        required = ""       
        data-aw="2"></textarea>
  </div>
</div>

