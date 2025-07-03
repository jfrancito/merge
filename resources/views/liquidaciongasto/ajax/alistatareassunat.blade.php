@if($mensaje!='')
<div role="alert" class="alert alert-danger alert-dismissible">
    <button type="button" data-dismiss="alert" aria-label="Close" class="close">
      <span aria-hidden="true" class="mdi mdi-close"></span></button><span class="icon mdi mdi-close-circle-o"></span>
      <strong>Error!</strong> {{$mensaje}}
</div>
@endif

<table id="nso" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
  <thead>
    <tr>
      <th>DOCUMENTO</th>
      <th>ARCHIVOS</th>
      <th>OPCIONES</th>
    </tr>
  </thead>
  <tbody>
    @foreach($listasunattareas as $index => $item)
      <tr>
          <td class="cell-detail">
            <span><b>RUC : </b>{{$item->RUC}}</span>
            <span><b>TD : </b>{{$item->TIPODOCUMENTO_NOMBRE}}</span>
            <span><b>SERIE : </b>{{$item->SERIE}}</span>
            <span><b>NUMERO : </b>{{$item->NUMERO}}</span>
            <span><b>FECHA BUSQUEDAD : </b>{{date_format(date_create($item->FECHA_MOD), 'd-m-Y h:i:s')}}</span>
          </td>
          <td class="cell-detail">
            <span><b>PDF : 
              @if($item->IND_PDF==1)
                <span class="mdi mdi-check-circle" style="display: inline-block;color: #34a853;"></span>
                <a href="{{ url('/descargar-archivo-lq/'.$item->ID_DOCUMENTO.'/'.$item->NOMBRE_PDF.'/PDF') }}">
                  <span class="mdi mdi-save" style="display: inline-block;color: #34a853;cursor: pointer;"></span>
                </a>  

              @else
                <span class="mdi mdi-close-circle" style="display: inline-block;color: #cc0000;"></span>
              @endif
              </b>
            </span>
            <span><b>XML : 
              @if($item->IND_XML==1)
                <span class="mdi mdi-check-circle" style="display: inline-block;color: #34a853;"></span>
                <a href="{{ url('/descargar-archivo-lq/'.$item->ID_DOCUMENTO.'/'.$item->NOMBRE_XML.'/XML') }}">
                  <span class="mdi mdi-save" style="display: inline-block;color: #34a853;cursor: pointer;"></span>
                </a>  

              @else
                <span class="mdi mdi-close-circle" style="display: inline-block;color: #cc0000;"></span>
              @endif

              </b></span>
            <span><b>CDR : 
              @if($item->IND_CDR==1)
                <a href="{{ url('/descargar-archivo-lq/'.$item->ID_DOCUMENTO.'/'.$item->NOMBRE_CDR.'/CDR') }}">
                  <span class="mdi mdi-save" style="display: inline-block;color: #34a853;cursor: pointer;"></span>
                </a>  

                <span class="mdi mdi-check-circle" style="display: inline-block;color: #34a853;"></span>
              @else
                <span class="mdi mdi-close-circle" style="display: inline-block;color: #cc0000;"></span>
              @endif
              </b></span>
            <span><b>COMPLETADO : 
              @if($item->IND_TOTAL==1)
                <span class="mdi mdi-check-circle" style="display: inline-block;color: #34a853;"></span>
              @else
                <span class="mdi mdi-close-circle" style="display: inline-block;color: #cc0000;"></span>
              @endif
              </b></span>
          </td>
          <td class="cell-detail user-info">
            <div class="icon iconoentregable">
              @if($item->IND_TOTAL==1)
                <span class="mdi mdi-select-all mdisellq" data_id='{{$item->ID_DOCUMENTO}}' data_ruc='{{$item->RUC}}' data_td='{{$item->TIPODOCUMENTO_ID}}' data_serie='{{$item->SERIE}}' data_numero='{{$item->NUMERO}}' style="color: #4285f4;"></span>
              @endif
              <span class="mdi mdi-close-circle mdicloselq" data_id='{{$item->ID_DOCUMENTO}}' data_ruc='{{$item->RUC}}' data_td='{{$item->TIPODOCUMENTO_ID}}' data_serie='{{$item->SERIE}}' data_numero='{{$item->NUMERO}}' style="color: #cc0000;"></span>
            </div>
          </td>
      </tr>                    
    @endforeach
  </tbody>
</table>
