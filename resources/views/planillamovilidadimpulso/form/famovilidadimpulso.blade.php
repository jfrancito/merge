<div class="control-group">
  <div class="row">

    @if(!isset($movilidad))

    <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 cajareporte">
        <div class="form-group ">
          <label class="col-sm-12 control-label labelleft" >Fecha Inicio :</label>
          <div class="col-sm-12 abajocaja" >
            <div data-min-view="2" 
                   data-date-format="dd-mm-yyyy"  
                   class="input-group date datetimepicker pickerfecha" style = 'padding: 0px 0;margin-top: -3px;'>
                   <input size="16" type="text" 
                          value="{{$fecha_inicio}}" 
                          placeholder="Fecha Inicio"
                          id='fecha_inicio' 
                          name='fecha_inicio' 
                          required = ""
                          class="form-control input-sm"/>
                    <span class="input-group-addon btn btn-primary"><i class="icon-th mdi mdi-calendar"></i></span>
              </div>
          </div>
        </div>
    </div> 

    <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 cajareporte">
      <div class="form-group ">
        <label class="col-sm-12 control-label labelleft" >Fecha Fin :</label>
        <div class="col-sm-12 abajocaja" >
          <div data-min-view="2" 
                 data-date-format="dd-mm-yyyy"  
                 class="input-group date datetimepicker pickerfecha" style = 'padding: 0px 0;margin-top: -3px;'>
                 <input size="16" type="text" 
                        value="{{$fecha_fin}}" 
                        placeholder="Fecha Fin"
                        id='fecha_fin' 
                        name='fecha_fin' 
                        required = ""
                        class="form-control input-sm"/>
                  <span class="input-group-addon btn btn-primary"><i class="icon-th mdi mdi-calendar"></i></span>
            </div>
        </div>
      </div>
    </div> 


    @endif
    <input type="hidden" name="area_id" value="{{$area_id}}">
    <input type="hidden" name="area_nombre" value="{{$area_nombre}}">
    <input type="hidden" name="centro_id" value="{{$centro_id}}">

    @if(isset($movilidad))

    <div class="ol-xs-12 col-sm-4 col-md-3 col-lg-3">
      <div class="form-group">
        <label class="col-sm-12 control-label labelleft negrita">RANGO DE DIAS :</label>
        <div class="col-sm-12">
            <input  type="text"
                    id="semana" name='semana' 
                    value="{{$movilidad->FECHA_INICIO}} // {{$movilidad->FECHA_FIN}}"                         
                    placeholder="SEMANA"
                    readonly = "readonly"
                    required = ""
                    autocomplete="off" class="form-control input-sm" data-aw="2"/>

        </div>
      </div>
    </div>

    <div class="ol-xs-12 col-sm-4 col-md-3 col-lg-3">
      <div class="form-group">
        <label class="col-sm-12 control-label labelleft negrita">TRABAJADOR :</label>
        <div class="col-sm-12">
            <input  type="text"
                    id="trabajador" name='trabajador' 
                    value="{{$movilidad->TXT_EMPRESA_TRABAJADOR}}"                         
                    placeholder="TRABAJADOR"
                    readonly = "readonly"
                    required = ""
                    autocomplete="off" class="form-control input-sm" data-aw="2"/>

        </div>
      </div>
    </div>
    <div class="ol-xs-12 col-sm-4 col-md-3 col-lg-3">
      <div class="form-group">
        <label class="col-sm-12 control-label labelleft negrita">TOTAL :</label>
        <div class="col-sm-12">
            <input  type="text"
                    id="monto" name='monto' 
                    value="{{$movilidad->MONTO}}"                         
                    placeholder="MONTO"
                    readonly = "readonly"
                    required = ""
                    autocomplete="off" class="form-control input-sm" data-aw="2"/>

        </div>
      </div>
    </div>


    <div class="row xs-pt-15">
      <div class="col-xs-6">
          <div class="be-checkbox">
          </div>
      </div>
      <div class="col-xs-6">
        <p class="text-right">
            <button type="submit" class="btn btn-space btn-success btnmovilidaddetalle">Guadar Detalle</button>     
        </p>
      </div>
    </div>


    @endif


  </div>
</div>



