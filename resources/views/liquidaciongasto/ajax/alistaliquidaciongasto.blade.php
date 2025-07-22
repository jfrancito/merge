<table id="tdpm" class="table table-striped table-striped  nowrap listatabla" style='width: 100%;'>
  <thead>
    <tr>
      <th>LIQUIDACION GASTO</th> 
    </tr>
  </thead>
  <tbody>
    @foreach($listacabecera as $index=>$item)
      <tr>
        <td class="cell-detail" style="position: relative;">

          <span style="display: block;"><b>ID : </b> {{$item->ID_DOCUMENTO}}</span>
          <span style="display: block;"><b>CODIGO : </b> {{$item->CODIGO}}</span>
          <span style="display: block;"><b>TRABAJADOR : </b> {{$item->TXT_EMPRESA_TRABAJADOR}}</span>
          <span style="display: block;"><b>FECHA EMISION : {{date_format(date_create($item->FECHA_EMI), 'd/m/Y')}}</b></span>
          <span style="display: block;"><b>FECHA CREACION : {{date_format(date_create($item->FECHA_CREA), 'd/m/Y')}}</b></span>
          <span style="display: block;"><b>PERIODO : </b> {{$item->TXT_PERIODO}}</span>
          <span style="display: block;"><b>CENTRO : </b> {{$item->TXT_CENTRO}}</span>
          <span style="display: block;"><b>AUTORIZA : </b> {{$item->TXT_USUARIO_AUTORIZA}}</span>
          <span style="display: block;"><b>TOTAL : </b> {{$item->TOTAL}}</span>
          <span><b>ESTADO : </b> @include('planillamovilidad.ajax.estados')</span>
          <span><b>OBSERVACION : </b> 
              @if($item->IND_OBSERVACION == '0') 
                  <span class="badge badge-defaults" style="display: inline-block;">SIN OBSERVACION</span>
              @else
                  <span class="badge badge-danger" style="display: inline-block;">{{$item->TXT_OBSERVACION}}</span>
              @endif
          </span>
          <a href="{{ url('/detalle-comprobante-lg-validado/'.$idopcion.'/'.Hashids::encode(substr($item->ID_DOCUMENTO, -8))) }}" style="margin-top: 5px;float: right;" class="btn btn-rounded btn-space btn-primary btn-sm">SEGUIMIENTO</a>
          <a href="{{ url('/modificar-liquidacion-gastos/'.$idopcion.'/'.Hashids::encode(substr($item->ID_DOCUMENTO, -8)).'/0') }}" style="margin-top: 5px;float: right;" class="btn btn-rounded btn-space btn-success btn-sm">MODIFICAR</a>
        
          @if($item->COD_ESTADO == 'ETM0000000000001')
            <form method="POST" id='forextornar' action="{{ url('/extonar-liquidacion-gastos/'.$idopcion.'/'.Hashids::encode(substr($item->ID_DOCUMENTO, -8))) }}" style="border-radius: 0px;" class="form-horizontal group-border-dashed">
                  {{ csrf_field() }}
                  <button type= 'button' style="margin-top: 5px;float: right;" class="btn btn-rounded btn-space btn-danger btn-sm btn-extonar-lg">EXTORNAR</button>
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
