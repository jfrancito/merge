<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">


<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

<table table id="tablaliquidacionespendientes" class="table table-striped table-borderless">
     <thead style="background-color: #1d3a6d; color: white;">
       <tr>
            <th>ITEM</th>
            <th>ID DOCUMENTO</th>
            <th>FEC EMISION</th>
            <th>CODIGO</th>
            <th>ESTADO</th>
            <th>MONEDA</th>
            <th>SUB TOTAL</th>
            <th>TOTAL</th>
        </tr>
    </thead>
    <tbody>
           @foreach($listarLiquidacionesPendientes as $index=>$item)
           <tr>
              <td>{{$item['ID_DOCUMENTO']}}</td>
              <td>{{$item['FECHA_EMI']}}</td>
              <td>{{$item['CODIGO']}}</td>
              <td>{{$item['ESTADO']}}</td>
              <td>{{$item['MONEDA']}}</td>
              <td>{{$item['SUB_TOTAL']}}</td>
              <td>{{$item['TOTAL']}}</td>
            </tr>
             
           @endforeach

      </tbody>

</table>

<script>
    
    @if(isset($ajax))
        $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();

        $('#tablaliquidacionespendientes').DataTable({
            pageLength: 10,
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
            },
            destroy: true
        });
    });
    @endif

</script>


