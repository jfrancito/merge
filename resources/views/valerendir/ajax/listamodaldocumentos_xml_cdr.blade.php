<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">


<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

@php
   $usuario = $listarDocumentoXML_CDR[0]['USUARIO_CREA'] ?? '';
@endphp

<div class="alert mt-1 p-2" 
     style="background-color: #f8d7da; border: 1px solid #f5c2c7; color: #333; 
            margin-left: 15px; font-size: 13px; font-weight: 400; 
            box-shadow: 0px 2px 6px rgba(0,0,0,0.1); line-height: 1.4;">
    <span style="font-weight: bold; color: black; font-size:16px; text-transform: uppercase;">
        {{ $usuario }}
    </span>  
    <span style="font-size:14px;">
        hasta la fecha el sistema no obtiene el XML y CDR de dichos comprobantes.  
        Por favor gestionar el envío de dicha documentación con el proveedor.
    </span>
</div>


<table table id="tablaDocumentoxml_cdr" class="table table-striped table-borderless">
  <thead style="background-color: #1d3a6d; color: white;">
        <tr>
            <th>ITEM</th>
            <th>ID DOCUMENTO</th>
            <th>FECHA CREA</th>
            <th>SERIE</th>
            <th>NUMERO</th>
            <th>FECHA EMISION</th>
            <th>PROVEEDOR</th>
            <th>TOTAL</th>
            <th>IND_PDF</th>
            <th>IND_XML</th>
            <th>IND_CDR</th>
            <th>BUSQUEDAD</th>
        </tr>
  </thead>
      <tbody>
          @foreach($listarDocumentoXML_CDR as $index=>$item)
           <tr>
              <td>{{ $index + 1 }}</td>
              <td>{{$item['ID_DOCUMENTO']}}</td>
              <td>{{$item['FEC_EMISION']}}</td>
              <td>{{$item['NRO_SERIE']}}</td>
              <td>{{$item['NUMERO']}}</td>
              <td>{{$item['FECHA_EMISIONDOC']}}</td>
              <td style=" padding-right:200px;">{{$item['PROVEEDOR']}}</td>
              <td>{{$item['TOTAL']}}</td>
              <td>{{$item['IND_PDF']}}</td>
              <td>{{$item['IND_XML']}}</td>
              <td>{{$item['IND_CDR']}}</td>
              <td>{{$item['BUSQUEDAD']}}</td>
            </tr>   
           @endforeach


      </tbody>
</table>

<script>
    
    @if(isset($ajax))
        $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();

        $('#tablaDocumentoxml_cdr').DataTable({
            pageLength: 10,
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
            },
            destroy: true
        });
    });
    @endif

    

</script>
