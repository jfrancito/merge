<div class="panel panel-default panel-contrast">
  <div class="panel-heading" style="background: #1d3a6d;color: #fff;">DETALLE DE DOCUMENTOS
  </div>
  <div class="panel-body panel-body-contrast">

  @foreach($tdetliquidaciongastos as $index => $item)
    <div class="dtlg {{$item->ID_DOCUMENTO}}{{$item->ITEM}} @if($index!=0) ocultar @endif" >
        <table class="table table-condensed table-striped">
          <thead>
            <tr>
              <th>RESPUESTA SUNAT</th>
              <th>ESTADO COMPROBANTE</th>
              <th>ESTADO RUC</th>
              <th>ESTADO DOMICILIO</th>
              <th>RESPUESTA CDR</th>
            </tr>
          </thead>
          <tbody>
              <tr>
                <td>{{$item->MESSAGE}}</td>
                <td>{{$item->NESTADOCP}}</td>
                <td>{{$item->NESTADORUC}}</td>
                <td>{{$item->NCONDDOMIRUC}}</td>
                <td>{{$item->RESPUESTA_CDR}}</td>
              </tr>
          </tbody>
        </table>
    </div>
  @endforeach



  @foreach($tdetliquidaciongastos as $index => $item)
    <div class="dtlg {{$item->ID_DOCUMENTO}}{{$item->ITEM}} @if($index!=0) ocultar @endif" >
        <table class="table table-condensed table-striped">
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
              <tr>
                <td>{{date_format(date_create($item->FECHA_EMISION), 'd/m/Y')}}</td>
                <td>{{$item->SERIE}} - {{$item->NUMERO}} </td>
                <td>{{$item->TXT_TIPODOCUMENTO}}</td>
                <td>{{$item->TXT_EMPRESA_PROVEEDOR}}</td>
                <td>{{$item->TOTAL}}</td>
              </tr>
          </tbody>
        </table>
    </div>
  @endforeach



  <table class="table table-condensed table-striped">
    <thead>
      <tr>
        <th>PRODUCTO</th> 
        <th>PRODUCTO XML</th>     
        <th>CANTIDAD</th>       
        <th>PRECIO</th>
        <th>IGV</th>
        <th>SU TOTAL</th>
        <th>TOTAL</th>
      </tr>
    </thead>
    <tbody>
      @foreach($detdocumentolg as $index => $item)
                  <tr class="dtlg {{$item->ID_DOCUMENTO}}{{$item->ITEM}}  @if($item->ITEM!=1) ocultar @endif">
                    <td>{{$item->TXT_PRODUCTO}}</td>
                    <td>{{$item->TXT_PRODUCTO_XML}}</td>                 
                    <td>{{$item->CANTIDAD}}</td>
                    <td>{{$item->PRECIO}}</td>
                    <td>{{$item->IGV}}</td>
                    <td>{{$item->SUBTOTAL}}</td>
                    <td>{{$item->TOTAL}}</td>
                  </tr>
      @endforeach
    </tbody>
  </table>
  @include('liquidaciongasto.form.liquidaciongasto.verpdfmultiple')
  </div>
</div>