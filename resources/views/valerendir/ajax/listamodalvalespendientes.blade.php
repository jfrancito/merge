<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">


<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

<table table id="tablaValespendientes" class="table table-striped table-borderless">
     <thead style="background-color: #1d3a6d; color: white;">
        <tr>
             <th>ITEM</th>
            <th>ID VALE</th>
            <th>FEC EMISION</th>
            <th>FEC VENCIMIENTO</th>
            <th>ID DOCUMENTO</th>
            <th>NRO SERIE</th>
            <th>NRO DOCUMENTO</th>
            <th>MONEDA</th>
            <th>SALDO</th>
        </tr>
    </thead>
    <tbody>
          @foreach($listarValePendientes as $index=>$item)
           <tr>
              <td>{{ $index + 1 }}</td>
              <td>{{$item['NRO_VALE']}}</td>
              <td>{{$item['FEC_EMISION']}}</td>
              <td>{{$item['FEC_VENCIMIENTO']}}</td>
              <td>{{$item['ID_DOCUMENTO_CONTABLE']}}</td>
              <td>{{$item['NRO_SERIE']}}</td>
              <td>{{$item['NRO_DOCUMENTO']}}</td>
              <td>{{$item['TIPO_MONEDA']}}</td>
              <td>{{$item['CAN_SALDO']}}</td>
            </tr>
             
           @endforeach


      </tbody>

</table>

<script>
    
    @if(isset($ajax))
        $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();

        $('#tablaValespendientes').DataTable({
            pageLength: 10,
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
            },
            destroy: true
        });
    });
    @endif

</script>



