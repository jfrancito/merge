<table id="tdpm" class="table table-striped table-striped  nowrap listatabla" style='width: 100%;'>
  <thead>
    <tr>
      <th>MOVILIDAD IMPULSO</th> 
    </tr>
  </thead>
  <tbody>
    @foreach($planillamovilidad as $index=>$item)
      <tr>
        <td class="cell-detail" style="position: relative;">
          <span style="display: block;"><b>SEMANA : </b> {{$item->FECHA_INICIO}} / {{$item->FECHA_FIN}}</span>
          <span style="display: block;"><b>AREA : </b> {{$item->AREA_TXT}}</span>
          <span style="display: block;"><b>CENTRO : </b> {{$item->CENTRO_TXT}}</span>
          <span style="display: block;"><b>FECHA CREACION : {{date_format(date_create($item->FECHA_CREA), 'd/m/Y')}}</b></span>
          <span style="display: block;"><b>TRABAJADOR : </b> {{$item->TXT_EMPRESA_TRABAJADOR}}</span>

          <span style="display: block;"><b>MONTO : </b> {{$item->MONTO}}</span>
          <span><b>OBSERVACION : </b> 
              @if($item->IND_OBSERVACION == '0') 
                  <span class="badge badge-defaults" style="display: inline-block;">SIN OBSERVACION</span>
              @else
                  <span class="badge badge-danger" style="display: inline-block;">OBSERVADO</span>
              @endif
          </span>

          <span><b>ESTADO : </b> @include('planillamovilidad.ajax.estados')</span>

          <a href="{{ url('/modificar-movilidad-impulso/'.$idopcion.'/'.Hashids::encode(substr($item->ID_DOCUMENTO, -8))) }}" 
            style="margin-top: 5px;float: right;" class="btn btn-rounded btn-space btn-success btn-sm">MODIFICAR</a>

          @if($item->COD_ESTADO == 'ETM0000000000001')
            <form method="POST" id='forextornar' action="{{ url('/extonar-planilla-movilidad-impulso/'.$idopcion.'/'.Hashids::encode(substr($item->ID_DOCUMENTO, -8))) }}" style="border-radius: 0px;" class="form-horizontal group-border-dashed">
                  {{ csrf_field() }}
<input type="hidden" name="device_info" id='device_info'>

                  <button type= 'button' style="margin-top: 5px;float: right;" class="btn btn-rounded btn-space btn-danger btn-sm btn-extonar-pm">EXTORNAR</button>
            </form>
          @endif


        </td>
      </tr>                    
    @endforeach
  </tbody>
</table>
@if(isset($ajax))
  <script type="text/javascript">
    $(document).ready(function(){
       App.dataTables();
    });
  </script> 
@endif
