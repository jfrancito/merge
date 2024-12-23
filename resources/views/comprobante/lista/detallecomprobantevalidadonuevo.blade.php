<div class="listadatos">  
        <div class="container">

          <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
              @include('comprobante.form.ordencompra.comparar')
            </div>
            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
              @if($fedocumento->OPERACION_DET != 'SIN_XML') @include('comprobante.form.ordencompra.sunat') @endif 
              @include('comprobante.form.ordencompra.infodetraccion')
              @include('comprobante.form.ordencompra.ordeningreso')
            </div>
            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
              @include('comprobante.form.ordencompra.seguimiento')
            </div> 
          </div>

          <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
              @include('comprobante.form.ordencompra.archivos')
            </div>

            <div class="col-xs-12 col-sm-6 col-md-8 col-lg-8">
              @include('comprobante.form.ordencompra.informacion')
            </div>
          </div>

          
          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
              @include('comprobante.form.ordencompra.pagobanco')
            </div>
          </div>

          
          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
              @include('comprobante.form.ordencompra.verarchivopdf')
            </div>
          </div>
          
          <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
              <div class="panel panel-default panel-contrast">
                <div class="panel-heading" style="background: #cc0000;color: #fff;">ARCHIVOS OBSERVADOS
                </div>
                <div class="panel-body panel-body-contrast">
                  <table class="table table-condensed table-striped">
                    <thead>
                      <tr>
                        <th>Nro</th>
                        <th>Nombre</th>      
                        <th>Archivo</th>       
                        <th>Opciones</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach($archivosanulados as $index => $item)  
                          <tr>
                            <td>{{$index + 1}}</td>
                            <td>{{$item->DESCRIPCION_ARCHIVO}}</td>
                            <td>{{$item->NOMBRE_ARCHIVO}}</td>

                            <td class="rigth">
                              <div class="btn-group btn-hspace">
                                <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Acción <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
                                <ul role="menu" class="dropdown-menu pull-right">
                                  <li>
                                    <a href="{{ url('/descargar-archivo-requerimiento-anulado/'.$item->TIPO_ARCHIVO.'/'.$idopcion.'/'.$linea.'/'.substr($ordencompra->COD_ORDEN, 0,6).'/'.Hashids::encode(substr($ordencompra->COD_ORDEN, -10))) }}">
                                      Descargar
                                    </a>  
                                  </li>
                                </ul>
                              </div>
                            </td>
                          </tr>
                        @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

          </div>



        </div>
</div>


