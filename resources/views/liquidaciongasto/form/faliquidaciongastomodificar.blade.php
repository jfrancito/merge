<div class="control-group">
  <div class="row">

    <div class="ol-xs-12 col-sm-4 col-md-3 col-lg-3">
      <div class="form-group">
        <label class="col-sm-12 control-label labelleft negrita">EMPRESA :</label>
        <div class="col-sm-12">
            <input  type="text"
                    id="empresa" name='empresa' 
                    value="{{$liquidaciongastos->TXT_EMPRESA_TRABAJADOR}}"                         
                    readonly = "readonly"
                    required = ""
                    autocomplete="off" class="form-control input-sm"/>
        </div>
      </div>
    </div>

    <div class="ol-xs-12 col-sm-4 col-md-3 col-lg-3">
      <div class="form-group">
        <label class="col-sm-12 control-label labelleft negrita">CUENTA :</label>
        <div class="col-sm-12">
            <input  type="text"
                    id="cuenta" name='cuenta' 
                    value="{{$liquidaciongastos->TXT_CUENTA}}"                         
                    readonly = "readonly"
                    required = ""
                    autocomplete="off" class="form-control input-sm"/>
        </div>
      </div>
    </div>

    <div class="ol-xs-12 col-sm-4 col-md-3 col-lg-3">
      <div class="form-group">
        <label class="col-sm-12 control-label labelleft negrita">SUB CUENTA :</label>
        <div class="col-sm-12">
            <input  type="text"
                    id="subcuenta" name='subcuenta' 
                    value="{{$liquidaciongastos->TXT_SUBCUENTA}}"                         
                    readonly = "readonly"
                    required = ""
                    autocomplete="off" class="form-control input-sm"/>
        </div>
      </div>
    </div>
    <div class="ol-xs-12 col-sm-4 col-md-3 col-lg-3">
      <div class="form-group">
        <label class="col-sm-12 control-label labelleft negrita">FECHA CREACION :</label>
        <div class="col-sm-12">
            <input  type="text"
                    id="fecha_crea_cab" name='fecha_crea_cab' 
                    value="{{date_format(date_create($liquidaciongastos->FECHA_CREA), 'd-m-Y h:i:s')}}"                         
                    readonly = "readonly"
                    required = ""
                    autocomplete="off" class="form-control input-sm"/>
        </div>
      </div>
    </div>


  </div>

  <div class="row" style="margin-top:10px;">
    <div class="ol-xs-12 col-sm-4 col-md-3 col-lg-3">
      <div class="form-group">
        <label class="col-sm-12 control-label labelleft negrita">CENTRO :</label>
        <div class="col-sm-12">
            <input  type="text"
                    id="centro_txt" name='centro_txt' 
                    value="{{$liquidaciongastos->TXT_CENTRO}}"                         
                    placeholder="NUMERO"
                    readonly = "readonly"
                    required = ""
                    autocomplete="off" class="form-control input-sm"/>
        </div>
      </div>
    </div>

    <div class="ol-xs-12 col-sm-4 col-md-3 col-lg-3">
      <div class="form-group">
        <label class="col-sm-12 control-label labelleft negrita">A RENDIR :</label>
        <div class="col-sm-12">
            <input  type="text"
                    id="arendir" name='arendir' 
                    value="{{$liquidaciongastos->ARENDIR}}"                         
                    placeholder="NUMERO"
                    readonly = "readonly"
                    required = ""
                    autocomplete="off" class="form-control input-sm"/>
        </div>
      </div>
    </div>

    <div class="ol-xs-12 col-sm-4 col-md-3 col-lg-3">
      <div class="form-group">
        <label class="col-sm-12 control-label labelleft negrita">AUTORIZA :</label>
        <div class="col-sm-12">
            <input  type="text"
                    id="autorizatxt" name='autorizatxt' 
                    value="{{$liquidaciongastos->TXT_USUARIO_AUTORIZA}}"                         
                    placeholder="NUMERO"
                    readonly = "readonly"
                    required = ""
                    autocomplete="off" class="form-control input-sm"/>
        </div>
      </div>
    </div>


    <div class="ol-xs-12 col-sm-4 col-md-3 col-lg-3">
      <div class="form-group">
        <label class="col-sm-12 control-label labelleft negrita">TOTAL :</label>
        <div class="col-sm-12">
            <input  type="text"
                    id="totalcabecera" name='totalcabecera' 
                    value="{{$liquidaciongastos->TOTAL}}"                         
                    placeholder="TOTAL"
                    readonly = "readonly"
                    required = ""
                    autocomplete="off" class="form-control input-sm"/>
        </div>
      </div>
    </div>



  </div>


</div>



