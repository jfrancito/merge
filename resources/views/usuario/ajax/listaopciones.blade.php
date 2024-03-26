<table class="table">
  <thead>
    <tr>
      <th style="text-center">Opciones</th>
      <th class="text-center" >
        <span data-toggle="tooltip" data-placement="top" title="Ver">V</span> 
      </th>
      <th class="text-center" >
        <span data-toggle="tooltip" data-placement="top" title="Agregar">A</span> 
      </th>
      <th class="text-center" >
        <span data-toggle="tooltip" data-placement="top" title="Modificar">M</span> 
      </th>
        <th class="text-center" >
        <span data-toggle="tooltip" data-placement="top" title="Todas">T</span> 
      </th>
    </tr>
  </thead>
  <tbody>

    @foreach($listaopciones as $item)
      <tr>
        <td class="cell-detail">
          <span>{{$item->opcion->nombre}}</span>
          <span class="cell-detail-description">({{$item->opcion->grupoopcion->nombre}})</span>
        </td>
        <td>
          <div class="text-center be-checkbox be-checkbox-sm">
            <input  type="checkbox"
                    class="{{Hashids::encode(substr($item->id, -8))}}"
                    id="1{{Hashids::encode(substr($item->id, -8))}}"
                    @if ($item->ver == 1) checked @endif
            >
            <label  for="1{{Hashids::encode(substr($item->id, -8))}}"
                    data-atr = "ver"
                    class = "checkbox"                    
                    name="{{Hashids::encode(substr($item->id, -8))}}"
              ></label>
          </div>
        </td> 
        <td>
          <div class="text-center be-checkbox be-checkbox-sm">
            <input  type="checkbox"
                    class="{{Hashids::encode(substr($item->id, -8))}}"
                    id="2{{Hashids::encode(substr($item->id, -8))}}"
                    @if ($item->anadir == 1) checked @endif
            >
            <label  for="2{{Hashids::encode(substr($item->id, -8))}}"
                    data-atr = "anadir"
                    class = "checkbox"                   
                    name="{{Hashids::encode(substr($item->id, -8))}}"
              ></label>
          </div>
        </td> 
        <td>
          <div class="text-center be-checkbox be-checkbox-sm">
            <input  type="checkbox"
                    class="{{Hashids::encode(substr($item->id, -8))}}"
                    id="3{{Hashids::encode(substr($item->id, -8))}}"
                    @if ($item->modificar == 1) checked @endif
            >
            <label  for="3{{Hashids::encode(substr($item->id, -8))}}"
                    data-atr = "modificar"
                    class = "checkbox"                    
                    name="{{Hashids::encode(substr($item->id, -8))}}"

              ></label>
          </div>
        </td> 
        <td>
          <div class="text-center be-checkbox be-checkbox-sm">
            <input  type="checkbox"
                    class="{{Hashids::encode(substr($item->id, -8))}}"
                    id="4{{Hashids::encode(substr($item->id, -8))}}"
                    @if ($item->todas == 1) checked @endif
            >
            <label  for="4{{Hashids::encode(substr($item->id, -8))}}"
                    data-atr = "todas"
                    class = "checkbox"                      
                    name="{{Hashids::encode(substr($item->id, -8))}}"
              ></label>
          </div>
        </td>
      </tr>                    
    @endforeach


  </tbody>
</table>