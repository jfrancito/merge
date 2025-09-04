<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">


<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

<table table id="tablalistafirmavale" class="table table-striped table-borderless">
  <thead style="background-color: #1d3a6d; color: white;">
        <tr>
            <th>ITEM</th>
            <th>ID</th>
            <th>FECHA</th>
            <th>SERIE</th>
            <th>NUMERO</th>
            <th>SOLICITA</th>
            <th>CONTRATO</th>
            <th>CULTIVO</th>
            <th>AUTORIZA</th>
            <th>DOCUMENTO</th>
            <th>MONEDA</th>
            <th>TIPO CAMBIO</th>
            <th>TOTAL</th>
            <th>SALDO</th>
            <th>ESTADO</th>
            <th>FIRMA/PDF</th>
        </tr>
  </thead>

      <tbody>
          @foreach($listarFirmaValeRendir as $index=>$item)
           <tr>
              <td>{{ $index + 1 }}</td>
              <td>{{$item['ID_AUTORIZACION']}}</td> 
              <td>{{$item['FECHA']}}</td>    
              <td>{{$item['SERIE']}}</td>    
              <td>{{$item['NUMERO']}}</td>    
              <td>{{$item['NOM_SOLICITA']}}</td>    
              <td>{{$item['CONTRATO']}}</td>               
              <td>{{$item['CULTIVO']}}</td>    
              <td>{{$item['TRA_AUTORIZA']}}</td>    
              <td>{{$item['DOCUMENTO']}}</td>  
              <td>{{$item['MONEDA']}}</td>
              <td>{{$item['TIPO_CAMBIO']}}</td>    
              <td>{{$item['TOTAL']}}</td>   
              <td>{{$item['SALDO']}}</td>   
              <td>
                <span class="badge badge-success">
                    {{ $item['ESTADO'] }}
                </span>
              </td>
              <td>
                <a href="{{ route('exportar_pdf', $item['ID_AUTORIZACION']) }}" class="btn-pdf">
                    <svg xmlns="http://www.w3.org/2000/svg" 
                         width="16" height="16" viewBox="0 0 24 24" 
                         fill="white" class="icon">
                        <path d="M6 2a2 2 0 0 0-2 2v16c0 
                                 1.1.9 2 2 2h12a2 2 0 0 
                                 0 2-2V8l-6-6H6zm7 7V3.5L18.5 
                                 9H13z"/>
                        <text x="5" y="20" 
                              font-size="7" 
                              font-weight="bold" 
                              fill="white">PDF</text>
                    </svg>
                    <span>PDF</span>
                </a>
            </td>
            </tr>   
           @endforeach
      </tbody>
</table>

<script>
@if(isset($ajax))
        $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();

        $('#tablalistafirmavale').DataTable({
            pageLength: 10,
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
            },
            destroy: true,
            ordering: false
        });
    });
    @endif



</script>

<style>
    .btn-pdf {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        font-size: 12px;
        font-weight: bold;
        color: white !important;        
        background-color: #e3342f;      
        border-radius: 20px;
        text-decoration: none !important; 
        transition: 0.2s ease-in-out;
    }

    .btn-pdf .icon {
        flex-shrink: 0;  
    }

    .btn-pdf:hover {
        background-color: #cc1f1a;   
        transform: scale(1.05);
        color: white !important;    
        text-decoration: none !important; 
    }
</style>

