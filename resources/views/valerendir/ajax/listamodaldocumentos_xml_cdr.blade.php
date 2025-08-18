<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">


<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

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
           <th> BUSQUEDAD</th>
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
