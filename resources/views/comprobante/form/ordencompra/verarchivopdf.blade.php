<div class="panel panel-default panel-contrast ver-archivos">
  <div class="panel-heading" style="background: #1d3a6d;color: #fff;">VER ARCHIVOS PDF  
    <a href="{{ url('/modificar-pdf-guias/'.$idopcion.'/'.$linea.'/'.substr($ordencompra->COD_DOCUMENTO_CTBLE, 0,7).'/'.Hashids::encode(substr($ordencompra->COD_DOCUMENTO_CTBLE, -9))) }}" class="btn btn-rounded btn-space btn-primary">GUIAS REMITENTE</a>
  </div>
  <div class="panel-body panel-body-contrast">
        @foreach($archivospdf as $index => $item)  
          <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
            <div class="form-group sectioncargarimagen">
                <label class="col-sm-12 control-label" style="text-align: left;font-size: 1em;"><b>{{$item->DESCRIPCION_ARCHIVO}}</b></label>
                <div class="col-sm-12">
                    <div class="file-loading">
                        <input 
                        id="file-{{$index}}" 
                        name="file[]" 
                        class="file-ver"  
                        type="file" 
                        multiple data-max-file-count="1">
                    </div>
                </div>
            </div>
          </div>
        @endforeach
  </div>
</div>