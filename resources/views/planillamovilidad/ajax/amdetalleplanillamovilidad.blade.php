<table id="tdpm" class="table table-striped table-striped  nowrap listatabla" style='width: 100%;'>
  <thead>
    <tr>
      <th>DETALLE DE PLANILLA MOVILIDAD</th> 
    </tr>
  </thead>
  <tbody>
    @foreach($tdetplanillamovilidad as $index=>$item)
      <tr>
        <td class="cell-detail" style="position: relative;">
          <span style="display: block;"><b>FECHA GASTO : {{date_format(date_create($item->FECHA_GASTO), 'd/m/Y')}}</b></span>
          <span style="display: block;"><b>MOTIVO : </b> {{$item->TXT_MOTIVO}}</span>
          <span style="display: block;"><b>LUGAR PARTIDA : </b> {{$item->TXT_LUGARPARTIDA}}</span>
          <span style="display: block;"><b>LUGAR DE LLEGADA : </b> {{$item->TXT_LUGARLLEGADA}}</span>
          <span style="display: block;"><b>TOTAL : </b > <b style="font-size: 20px;">{{number_format($item->TOTAL, 2, '.', ',')}}</b></span>
          <button type="button" data_iddocumento = "{{$item->ID_DOCUMENTO}}" data_item = "{{$item->ITEM}}" style="margin-top: 5px;float: right;" class="btn btn-rounded btn-space btn-success btn-sm modificardetallepm">MODIFICAR</button>
        </td>
      </tr>                 
    @endforeach
  </tbody>
</table>


