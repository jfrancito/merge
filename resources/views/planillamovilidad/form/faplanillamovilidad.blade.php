<div class="control-group">

  <div class="row">
    <div class="ol-xs-12 col-sm-4 col-md-3 col-lg-3">
      <div class="form-group">
        <label class="col-sm-12 control-label labelleft negrita">PERIODO :</label>
        <div class="col-sm-12">
            <input  type="text"
                    id="periodo" name='periodo' 
                    value="{{$periodo->TXT_NOMBRE}}"                         
                    placeholder="PERIODO"
                    readonly = "readonly"
                    required = ""
                    autocomplete="off" class="form-control input-sm" data-aw="1"/>

            @include('error.erroresvalidate', [ 'id' => $errors->has('periodo')  , 
                                                'error' => $errors->first('periodo', ':message') , 
                                                'data' => '1'])
        </div>
      </div>
    </div>
    <input type="hidden" name="cod_mes" id="cod_mes" value="{{$periodo->COD_MES}}">
    <input type="hidden" name="cod_anio" id="cod_anio" value="{{$periodo->COD_ANIO}}">
    <div class="ol-xs-12 col-sm-4 col-md-3 col-lg-3">
      <div class="form-group">
        <label class="col-sm-12 control-label labelleft negrita">SERIE :</label>
        <div class="col-sm-12">
            <input  type="text"
                    id="serie" name='serie' 
                    value="{{$serie}}"                         
                    placeholder="SERIE"
                    readonly = "readonly"
                    required = ""
                    autocomplete="off" class="form-control input-sm" data-aw="2"/>

            @include('error.erroresvalidate', [ 'id' => $errors->has('serie')  , 
                                                'error' => $errors->first('serie', ':message') , 
                                                'data' => '2'])
        </div>
      </div>
    </div>

    <div class="ol-xs-12 col-sm-4 col-md-3 col-lg-3">
      <div class="form-group">
        <label class="col-sm-12 control-label labelleft negrita">NUMERO :</label>
        <div class="col-sm-12">
            <input  type="text"
                    id="numero" name='numero' 
                    value="{{$numero}}"                         
                    placeholder="NUMERO"
                    readonly = "readonly"
                    required = ""
                    autocomplete="off" class="form-control input-sm" data-aw="3"/>

            @include('error.erroresvalidate', [ 'id' => $errors->has('numero')  , 
                                                'error' => $errors->first('numero', ':message') , 
                                                'data' => '3'])
        </div>
      </div>
    </div>

    <div class="ol-xs-12 col-sm-4 col-md-3 col-lg-3">
      <div class="form-group">
        <label class="col-sm-12 control-label labelleft negrita">FECHA CREACION :</label>
        <div class="col-sm-12">
            <input  type="text"
                    id="fecha_creacion" name='fecha_creacion' 
                    value="{{date_format(date_create($fecha_creacion), 'd-m-Y h:i:s')}}"                         
                    placeholder="NUMERO"
                    readonly = "readonly"
                    required = ""
                    autocomplete="off" class="form-control input-sm" data-aw="4"/>

            @include('error.erroresvalidate', [ 'id' => $errors->has('fecha_creacion')  , 
                                                'error' => $errors->first('fecha_creacion', ':message') , 
                                                'data' => '4'])
        </div>
      </div>
    </div>
  </div>

  <div class="row" style="margin-top: 15px;">
    <div class="ol-xs-12 col-sm-4 col-md-3 col-lg-3">
      <div class="form-group">
        <label class="col-sm-12 control-label labelleft negrita">NOMBRES Y APELLIDOS :</label>
        <div class="col-sm-12">
            <input  type="text"
                    id="txttrabajador" name='txttrabajador' 
                    value="{{$txttrabajador}}"                         
                    placeholder="NOMBRES Y APELLIDOS"
                    readonly = "readonly"
                    required = ""
                    autocomplete="off" class="form-control input-sm" data-aw="5"/>

            @include('error.erroresvalidate', [ 'id' => $errors->has('txttrabajador')  , 
                                                'error' => $errors->first('txttrabajador', ':message') , 
                                                'data' => '5'])
        </div>
      </div>
    </div>

    <div class="ol-xs-12 col-sm-4 col-md-3 col-lg-3">
      <div class="form-group">
        <label class="col-sm-12 control-label labelleft negrita">DNI :</label>
        <div class="col-sm-12">
            <input  type="text"
                    id="doctrabajador" name='doctrabajador' 
                    value="{{$doctrabajador}}"                         
                    placeholder="DNI"
                    readonly = "readonly"
                    required = ""
                    autocomplete="off" class="form-control input-sm" data-aw="2"/>

            @include('error.erroresvalidate', [ 'id' => $errors->has('doctrabajador')  , 
                                                'error' => $errors->first('doctrabajador', ':message') , 
                                                'data' => '2'])
        </div>
      </div>
    </div>

    <div class="ol-xs-12 col-sm-4 col-md-3 col-lg-3">
      <div class="form-group">
        <label class="col-sm-12 control-label labelleft negrita">CENTRO :</label>
        <div class="col-sm-12">
            <input  type="text"
                    id="centro" name='centro' 
                    value="{{$centro}}"                         
                    placeholder="CENTRO"
                    readonly = "readonly"
                    required = ""
                    autocomplete="off" class="form-control input-sm" data-aw="2"/>

            @include('error.erroresvalidate', [ 'id' => $errors->has('centro')  , 
                                                'error' => $errors->first('centro', ':message') , 
                                                'data' => '2'])
        </div>
      </div>
    </div>


    @if(isset($planillamovilidad))
    <div class="ol-xs-12 col-sm-4 col-md-3 col-lg-3">
      <div class="form-group">
        <label class="col-sm-12 control-label labelleft negrita">TOTAL :</label>
        <div class="col-sm-12">
            <input  type="text"
                    id="total" name='total' 
                    value="{{$planillamovilidad->TOTAL}}"                         
                    placeholder="TOTAL"
                    readonly = "readonly"
                    autocomplete="off" class="form-control input-sm" style="font-size: 22px; font-weight: bold;text-align: right;" />

        </div>
      </div>
    </div>
    @endif

  </div>


  <div class="row" style="margin-top: 15px;">
    @if(isset($planillamovilidad))
      <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
        <div class="form-group">
          <label class="col-sm-12 control-label labelleft negrita">GLOSA :</label>
            <div class="col-sm-12">
                <textarea 
                name="glosa"
                id = "glosa"
                required = ""
                class="form-control input-sm validarmayusculas"
                rows="2">{{$planillamovilidad->TXT_GLOSA}}</textarea>
            </div>
        </div>
      </div>
    
    @endif



  </div>




</div>



