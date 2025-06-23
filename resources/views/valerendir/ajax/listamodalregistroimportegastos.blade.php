<table id="importegastos" class="table table-bordered td-color-borde td-padding-7 display nowrap "
       cellspacing="0" width="100%" style="font-style: italic;">
    <thead>
        <tr>
            <th style="text-align: center;">ID</th>
            <th style="text-align: center;">Centro</th>
            <th style="text-align: center;">Departamento</th>
            <th style="text-align: center;">Provincia</th>
            <th style="text-align: center;">Distrito</th>
            <th style="text-align: center;">Importe</th>
            <th style="text-align: center;">Tipo</th>
            <th style="text-align: center;">Indicador<br>(Ruta corta)</th>
            <th style="text-align: center;">Eliminar</th>  

        </tr>
    </thead>
    <tbody>
        @foreach($listarimportegastos as $index=>$item)

        
         <tr class="dobleclickpc" data_importe_gastos="{{$item['ID']}}" style="cursor:pointer;">
            <td>{{$item['ID']}}</td>
            <td>{{$item['NOM_CENTRO']}}</td>
            <td>{{$item['NOM_DEPARTAMENTO']}}</td>
            <td>{{$item['NOM_PROVINCIA']}}</td>
            <td>{{$item['NOM_DISTRITO']}}</td>
            <td>S/. {{$item['CAN_TOTAL_IMPORTE']}}</td>
            <td>{{$item['TIPO']}}</td>
            <td>{{ $item['IND_DESTINO'] == 1 ? 'Sí' : 'No' }}</td>
        

            <td class="text-center align-middle">
          <button class="btn-rojo delete-registroimportegastos">
            <i class="icon mdi mdi-delete"></i>
          </button>
        </td>
         
        </tr>
         
        @endforeach
    </tbody>
</table>
<style>
  .btn-rojo {
    background-color: #d9534f;
    color: white;
    border: none;
    padding: 6px 10px;
    border-radius: 4px;
  }

  .btn-rojo i {
    color: white;
  }

  .btn-rojo:hover {
    background-color: #c9302c;
  }

  thead th {
    background: #1d3a6d;; 
    color: white;              
    text-align: center;
    vertical-align: middle;
  }

     .selected {
    background-color: #7d9ac0 !important;
    color: #FFFFFF;
    vertical-align: middle;
    padding: 1.5em;
    }
</style>
