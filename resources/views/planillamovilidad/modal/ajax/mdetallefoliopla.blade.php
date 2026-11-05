<div class="scroll_text scroll_text_heigth_aler" style = "padding: 0px !important;"> 

<div class="icon iconoentregable">
  <span class="mdi mdi-floppy mdisave" 
        data_iddocumento='@if(isset($entregagle_a)){{$entregagle_a->ID_DOCUMENTO }}@endif' 
        data_folio='@if(isset($entregagle_a)){{$entregagle_a->FOLIO }}@endif' 
        data_glosa='@if(isset($entregagle_a)){{$entregagle_a->TXT_GLOSA}}@endif'
        data_cantidad='@if(isset($entregagle_a)){{$entregagle_a->CAN_FOLIO}}@endif'
        data_periodo='@if(isset($entregagle_a)){{$entregagle_a->TXT_PERIODO}}@endif'
>
  </span>
</div>
  <table  class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
    <thead>
      <tr>
        <th>DETALLE</th>
        <th>TOTAL</th>
      </tr>
    </thead>
    <tbody>
      @php $monto_total =  0; @endphp
      @foreach($lfedocumento as $index => $item)
        <tr>
          <td class="cell-detail sorting_1" style="position: relative;">
            <span><b>ID: </b> {{$item->ID_DOCUMENTO}}  </span>
            <span><b>DOCUMENTO: </b> {{$item->SERIE}} - {{$item->NUMERO}} </span>
            <span><b>PROVEEDOR: </b> {{$item->TXT_TRABAJADOR}}  </span>
          </td>
          <td class="cell-detail sorting_1" style="position: relative;">
            <b style="font-size: 18px;">{{$item->TOTAL}} </b>
          </td>
          @php $monto_total =  $monto_total +  $item->TOTAL; @endphp
        </tr>                    
      @endforeach
    </tbody>
      <tfoot>
          <tr>
            <td></td>
            <td><b style="font-size: 18px;">{{number_format($monto_total, 4, '.', ',')}}</b></td>
          </tr>                    
      </tfoot>

  </table>
</div>