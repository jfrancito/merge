<table table id="tablalistanegraproveedores" class="table table-striped table-borderless">
  <thead style="background-color: #1d3a6d; color: white;">
        <tr>
            <th>ITEM</th>
            <th>PROVEEDOR</th>
            <th>NRO RUC</th>
           
        </tr>
  </thead>
      <tbody>
          @foreach($listarlistanegra as $index=>$item)
           <tr>
              <td>{{ $index + 1 }}</td>
              <td>{{$item['PROVEEDOR']}}</td>
               <td>{{$item['RUC_PROVEEDOR']}}</td>
              
            </tr>   
           @endforeach


      </tbody>
</table>

<script>
@if(isset($ajax))
        $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();

        $('#tablalistanegraproveedores').DataTable({
            pageLength: 10,
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
            },
            destroy: true
        });
    });
    @endif

</script>