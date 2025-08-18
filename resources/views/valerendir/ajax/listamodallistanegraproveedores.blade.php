<div class="alert mt-1 p-2" 
     style="background-color: #f8d7da; border: 1px solid #f5c2c7; color: #333; 
            margin-left: 15px; font-size: 13px; font-weight: 400; 
            box-shadow: 0px 2px 6px rgba(0,0,0,0.1); line-height: 1.4;">
   
    <span style="font-size:14px;">
   <strong>Estimados colaboradores:</strong> Se les informa que la siguiente lista de proveedores no está enviando correctamente su XML y CDR.
    Se recomienda evitar realizar operaciones con dichos proveedores.
    </span>
</div>

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