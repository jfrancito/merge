<div class="tab-container">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#conei" class="conei" data-toggle="tab"><b> INTEGRANTES </b></a></li>
    <li><a href="#archivo" class="conei" data-toggle="tab"><b> EXPEDIENTES </b></a></li>
  </ul>
  <div class="tab-content">
    <div id="conei" class="tab-pane active cont">
      <fieldset>
        <legend>PERIODO CONEI </legend>
            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label"><b>Periodo : </b></label>
                  <input  type="text"
                          id="director_nombres" name='director_nombres' 
                          value="{{$conei->periodo_nombre}}"                         
                          required = ""                   
                          autocomplete="off" class="form-control input-sm director_nombres" data-aw="4" readonly/>
              </div>
            </div>
      </fieldset>
      <fieldset>
        <legend>INTEGRANTES </legend>
            <input type="hidden" name="institucion_id" id = 'institucion_id' value='{{$institucion->id}}'>
            <input type="hidden" name="director_id" id = 'director_id' value='{{$director->id}}'>
            <div class="col-sm-6">
              <div class="form-group">

                  <label class="control-label"><b>DIRECTOR : <small class="obligatorio">(*) Obligatorio</small></b></label>
                  <input  type="text"
                          id="director_nombres" name='director_nombres' 
                          value="{{$conei->documento_director}} - {{$conei->nombres_director}}"                          
                          placeholder="DIRECTOR"
                          required = ""                   
                          autocomplete="off" class="form-control input-sm director_nombres" data-aw="4" readonly/>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">

                  <label class="control-label"><b>SUBDIRECTOR : <small class="obligatorio">(*) Obligatorio</small></b></label>

                  <input  type="text"
                          id="subdirector_nombres" name='subdirector_nombres' 
                          value="{{$conei->documento_subdirector}} - {{$conei->nombres_subdirector}}"                           
                          placeholder="SUBDIRECTOR"
                          required = ""                   
                          autocomplete="off" class="form-control input-sm subdirector_nombres" data-aw="4" readonly/>

              </div>
            </div>


            <div class="col-sm-6">
              <div class="form-group">

                  <label class="control-label"><b>REPRESENTANTE DE DOCENTE : <small class="obligatorio">(*) Obligatorio</small></b></label>

                  <input  type="text"
                          id="representantedocente_nombres" name='representantedocente_nombres' 
                          value="{{$conei->documento_redoc}} - {{$conei->nombres_redoc}}"                         
                          placeholder="REPRESENTANTE DE DOCENTE"
                          required = ""                   
                          autocomplete="off" class="form-control input-sm representantedocente_nombres" data-aw="4" readonly/>


              </div>
            </div>

            <div class="col-sm-6">
              <div class="form-group">

                  <label class="control-label"><b>REPRESENTANTE DE APAFA : <small class="obligatorio">(*) Obligatorio</small></b></label>

                  <input  type="text"
                          id="representanteapafa_nombres" name='representanteapafa_nombres' 
                          value="{{$conei->documento_reapf}} - {{$conei->nombres_reapf}}"                         
                          placeholder="REPRESENTANTE DE APAFA"
                          required = ""                   
                          autocomplete="off" class="form-control input-sm representanteapafa_nombres" data-aw="4" readonly/>


              </div>
            </div>

            <div class="col-sm-6">
              <div class="form-group">

                  <label class="control-label"><b>OTRO REPRESENTANTE DE LA COMUNIDAD : <small class="obligatorio">(*) Obligatorio</small></b></label>

                  <input  type="text"
                          id="otrorepresentatecomunidad_nombres" name='otrorepresentatecomunidad_nombres' 
                          value="{{$conei->documento_reorc}} - {{$conei->nombres_reorc}}"                       
                          placeholder="OTRO REPRESENTANTE DE LA COMUNIDAD"
                          required = ""                   
                          autocomplete="off" class="form-control input-sm otrorepresentatecomunidad_nombres" data-aw="4" readonly/>

              </div>
            </div>



            <div class="col-sm-6">
              <div class="form-group">

                  <label class="control-label"><b>REPRESENTANTE DE ADMINISTRATIVO : <small class="opcional">(**) Opcional</small></b></label>

                  <input  type="text"
                          id="representanteadministrativo_nombres" name='representanteadministrativo_nombres' 
                          value="{{$conei->documento_readm}} - {{$conei->nombres_readm}}"                        
                          placeholder="REPRESENTANTE DE ADMINISTRATIVO"                
                          autocomplete="off" class="form-control input-sm representanteadministrativo_nombres" data-aw="4" readonly/>



              </div>
            </div>


            <div class="col-sm-6">
              <div class="form-group">

                  <label class="control-label"><b>REPRESENTANTE DE ESTUDIANTE : <small class="opcional">(**) Opcional</small></b></label>

                  <input  type="text"
                          id="representanteestudiante_nombres" name='representanteestudiante_nombres' 
                          value="{{$conei->documento_reest}} - {{$conei->nombres_reest}}"                         
                          placeholder="REPRESENTANTE DE ESTUDIANTE"                  
                          autocomplete="off" class="form-control input-sm representanteestudiante_nombres" data-aw="4" readonly/>


              </div>
            </div>


            <div class="col-sm-6">
              <div class="form-group">

                  <label class="control-label"><b>REPRESENTANTE DE EX ALUMNO : <small class="opcional">(**) Opcional</small></b></label>

                  <input  type="text"
                          id="representanteexalumno_nombres" name='representanteexalumno_nombres' 
                          value="{{$conei->documento_rexal}} - {{$conei->nombres_rexal}}"                        
                          placeholder="REPRESENTANTE DE EX ALUMNO"                  
                          autocomplete="off" class="form-control input-sm representanteexalumno_nombres" data-aw="4" readonly/>


              </div>
            </div>
      </fieldset>
      <fieldset>
        <legend>OTROS INTEGRANTES </legend>
            <div class = 'listaajaxoi'>
              @include('requerimiento.lista.ajax.alistaoidetconei')
            </div>
      </fieldset>




      <br><br>
      <div style="text-align: right;">
        <button type="button" class="btn btn-space btn-success btn-next">Siguiente</button>
      </div>
    </div>

    <div id="archivo" class="tab-pane cont">

      <fieldset>
        <legend>ARCHIVOS</legend>


          <table id="nso" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
            <thead>
              <tr>
                <th>Nro</th>
                <th>Descripcion</th>      
                <th>Extension</th>      
                <th>Tamaño(MB)</th>      
                <th>Opciones</th>
              </tr>
            </thead>
            <tbody>
              @foreach($larchivos as $index => $item)
                <tr data_precotizacion_id = "{{$item->id}}">
                  <td>{{ $index+1 }}</td>
                  <td class="cell-detail" >
                    <span><b>Lote : </b> {{$item->lote}}</span>
                    <span><b>Fecha Subida: </b> {{date_format(date_create($item->fecha_crea), 'd-m-Y H:i')}} </span>
                    <span><b>Nombre Documento : </b> {{$item->nombre_doc}} </span>
                    <span><b>Periodo : </b> {{$item->periodo_nombre}} </span>
                  </td>
                  <td>
                    <img src="{{ asset('/public/img/icono/'.$item->extension.'.png')}}" width="40px" height="50px" alt="{{ $item->extension }}">
                  </td>
                  <td>
                    {{ round($item->size/pow(1024,$unidad),2) }}
                  </td>


                  <td class="rigth">
                    <div class="btn-group btn-hspace">
                      <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Acción <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
                      <ul role="menu" class="dropdown-menu pull-right">
                        <li>
                          <a href="{{ url('/descargar-archivo-requerimiento/'.$idopcion.'/'.Hashids::encode(substr($item->id, -8)).'/'.Hashids::encode(substr($item->id, -8))) }}">
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





      </fieldset>


    </div>

  </div>
</div>

