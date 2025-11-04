<div class="control-group">
  <div class="row">

    @if(!isset($movilidad))
    <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3 ajax_combo_cuenta">
        <div class="form-group">
          <label class="col-sm-12 control-label labelleft" style="text-align: left;">SEMANA <span class="obligatorio">(*)</span>:</label>
          <div class="col-sm-12 abajocaja" >
            {!! Form::select( 'semana_id', $combosemana, array($semana_id),
                              [
                                'class'       => 'select2 form-control control input-sm' ,
                                'id'          => 'semana_id',
                                'required'    => '',
                              ]) !!}

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
        <label class="col-sm-12 control-label labelleft negrita">SEMANA :</label>
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



