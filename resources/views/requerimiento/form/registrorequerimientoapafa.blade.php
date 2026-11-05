<div class="tab-container">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#informacion" data-toggle="tab"><b> INFORMACION</b></a></li>
    <li><a href="#apafa" class="apafa" data-toggle="tab"><b> APAFA </b></a></li>
  </ul>
  <div class="tab-content">
    <div id="informacion" class="tab-pane active cont">

      <fieldset>
        <legend>DATOS DE LA II.EE.</legend>

            <input type="hidden" name="institucion_id" id = 'institucion_id' value='{{$institucion->id}}'>
            <div class="col-sm-3">
              <div class="form-group">
                <label class="control-label"><b>CODIGO INSTITUTO <small class="">(II.EE.)</small> : </b></label>
                <p>{{$institucion->codigo}}</p>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label class="control-label"><b>NOMBRE DE LA II.EE. <small class="">(II.EE.)</small> : </b></label>
                <p>{{strtoupper($institucion->nombre)}}</p>

              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label class="control-label"><b>DEPARTAMENTO <small class="">(II.EE.)</small> : </b></label>
                <p>{{strtoupper($institucion->departamento)}} - {{strtoupper($institucion->departamento)}} - {{strtoupper($institucion->distrito)}}</p>

              </div>
            </div>
      </fieldset>
      <fieldset>
        <legend>DATOS DEL DIRECTOR</legend>

            <input type="hidden" name="director_id" id = 'director_id' value='{{$director->id}}'>

            <div class="col-sm-6">
              <div class="form-group">
                <label class="control-label"><b>NOMBRES <small class="">(Director)</small> : </b></label>
                <input  type="text"
                        id="nombre_director" name='nombre_director' 
                        value="{{$director->nombres}}"                        
                        placeholder="NOMBRES"
                        required = ""
                        maxlength="300"                     
                        autocomplete="off" class="form-control input-sm nombre_director" data-aw="1" readonly/>
                @include('error.erroresvalidate', [ 'id' => $errors->has('nombre_director')  , 
                                              'error' => $errors->first('nombre_director', ':message') , 
                                              'data' => '1'])
              </div>
            </div>

            <div class="col-sm-3">
              <div class="form-group">
                <label class="control-label"><b>TELEFONO <small class="">(Director)</small> : </b></label>
                <input  type="text"
                        id="telefono_director" name='telefono_director' 
                        value="{{$director->telefono}}"                    
                        placeholder="TELEFONO"
                        required = ""
                        maxlength="50"                     
                        autocomplete="off" class="form-control input-sm telefono_director" data-aw="2"/>
                @include('error.erroresvalidate', [ 'id' => $errors->has('telefono_director')  , 
                                              'error' => $errors->first('telefono_director', ':message') , 
                                              'data' => '2'])
              </div>
            </div>

            <div class="col-sm-3">
              <div class="form-group">
                <label class="control-label"><b>CORREO ELECTRONICO <small class="">(Director)</small> : </b></label>
                <input  type="text"
                        id="correo_director" name='correo_director' 
                        value="{{$director->correo}}"                     
                        placeholder="CORREO ELECTRONICO"
                        required = ""
                        maxlength="50"                     
                        autocomplete="off" class="form-control input-sm correo_director" data-aw="3"/>
                @include('error.erroresvalidate', [ 'id' => $errors->has('correo_director')  , 
                                              'error' => $errors->first('correo_director', ':message') , 
                                              'data' => '3'])
              </div>
            </div>
      </fieldset>
      <br>
      <div style="text-align: right;">
        <button type="button" class="btn btn-space btn-success btn-next">Siguiente</button>
      </div>
    </div>
    <div id="apafa" class="tab-pane cont">



      <fieldset>
        <legend>CONSEJO DIRECTIVO </legend>
        
            <div class="col-sm-3">
              <div class="form-group">
                <label class="control-label"><b>Tipo Documento <small class="">(Presidente)</small> : </b></label>

                {!! Form::select( 'cd_tipodocumento_presidente', $combotd, $selecttd,
                                  [
                                    'class'       => 'select2 form-control control input-xs combo' ,
                                    'id'          => 'cd_tipodocumento_presidente',
                                    'data-aw'     => '4'
                                  ]) !!}

                @include('error.erroresvalidate', [ 'id' => $errors->has('cd_tipodocumento_presidente')  , 
                                              'error' => $errors->first('cd_tipodocumento_presidente', ':message') , 
                                              'data' => '4'])
              </div>
            </div>
            <div class="col-sm-4">
              <div class="input-group my-group">
                  <label class="control-label"><b>Documento <small class="">(Presidente)</small> : </b></label>
                  <input  type="text"
                          id="cd_dni_presidente_apafa" name='cd_dni_presidente_apafa' 
                          value=""
                          value="{{ old('cd_dni_presidente_apafa') }}"                         
                          placeholder="DNI"
                          required = ""
                          maxlength="10"                     
                          autocomplete="off" class="form-control input-sm cd_dni_presidente_apafa" data-aw="5"/>
                  @include('error.erroresvalidate', [ 'id' => $errors->has('cd_dni_presidente_apafa')  , 
                                                'error' => $errors->first('cd_dni_presidente_apafa', ':message') , 
                                                'data' => '5'])

                    <span class="input-group-btn">
                      <button class="btn btn-primary btn-buscar_dni"
                              data_dni = 'cd_dni_presidente_apafa'
                              data_nombre = 'cd_nombre_presidente_apafa'
                              type="button" 
                              style="margin-top: 26px;height: 37px;">
                              Buscar Reniec</button>
                    </span>
              </div>
            </div>

            <div class="col-sm-5">
              <div class="form-group">
                <label class="control-label"><b>NOMBRES <small class="">(Presidente)</small> : </b></label>
                <input  type="text"
                        id="cd_nombre_presidente_apafa" name='cd_nombre_presidente_apafa' 
                        value=""
                        value="{{ old('cd_nombre_presidente_apafa') }}"                         
                        placeholder="NOMBRES"
                        required = ""
                        maxlength="300"                     
                        autocomplete="off" class="form-control input-sm cd_nombre_presidente_apafa" data-aw="6"/>
                @include('error.erroresvalidate', [ 'id' => $errors->has('cd_nombre_presidente_apafa')  , 
                                              'error' => $errors->first('cd_nombre_presidente_apafa', ':message') , 
                                              'data' => '6'])
              </div>
            </div>



            <div class="col-sm-3">

              <div class="form-group">
                <label class="control-label"><b>Tipo Documento <small class="">(VicePresidente)</small> : </b></label>

                {!! Form::select( 'cd_tipodocumento_vicepresidente', $combotd, $selecttd,
                                  [
                                    'class'       => 'select2 form-control control input-xs combo' ,
                                    'id'          => 'cd_tipodocumento_vicepresidente',
                                    'data-aw'     => '4'
                                  ]) !!}

                @include('error.erroresvalidate', [ 'id' => $errors->has('cd_tipodocumento_vicepresidente')  , 
                                              'error' => $errors->first('cd_tipodocumento_vicepresidente', ':message') , 
                                              'data' => '4'])
              </div>
            </div>

            <div class="col-sm-4">
              <div class="input-group my-group">
                  <label class="control-label"><b>Documento <small class="">(VicePresidente)</small> : </b></label>
                  <input  type="text"
                          id="cd_dni_vicepresidente_apafa" name='cd_dni_vicepresidente_apafa' 
                          value=""
                          value="{{ old('cd_dni_vicepresidente_apafa') }}"                         
                          placeholder="DNI"
                          required = ""
                          maxlength="10"                     
                          autocomplete="off" class="form-control input-sm cd_dni_vicepresidente_apafa" data-aw="5"/>
                  @include('error.erroresvalidate', [ 'id' => $errors->has('cd_dni_vicepresidente_apafa')  , 
                                                'error' => $errors->first('cd_dni_vicepresidente_apafa', ':message') , 
                                                'data' => '5'])

                    <span class="input-group-btn">
                      <button class="btn btn-primary btn-buscar_dni"
                              data_dni = 'cd_dni_vicepresidente_apafa'
                              data_nombre = 'cd_nombre_vicepresidente_apafa'
                              type="button" 
                              style="margin-top: 26px;height: 37px;">
                              Buscar Reniec</button>
                    </span>
              </div>
            </div>

            <div class="col-sm-5">
              <div class="form-group">
                <label class="control-label"><b>NOMBRES <small class="">(VicePresidente)</small> : </b></label>
                <input  type="text"
                        id="cd_nombre_vicepresidente_apafa" name='cd_nombre_vicepresidente_apafa' 
                        value=""
                        value="{{ old('cd_nombre_vicepresidente_apafa') }}"                         
                        placeholder="NOMBRES"
                        required = ""
                        maxlength="300"                     
                        autocomplete="off" class="form-control input-sm cd_nombre_vicepresidente_apafa" data-aw="6"/>
                @include('error.erroresvalidate', [ 'id' => $errors->has('cd_nombre_vicepresidente_apafa')  , 
                                              'error' => $errors->first('cd_nombre_vicepresidente_apafa', ':message') , 
                                              'data' => '6'])
              </div>
            </div>



            <div class="col-sm-3">

              <div class="form-group">
                <label class="control-label"><b>Tipo Documento <small class="">(Secretario)</small> : </b></label>

                {!! Form::select( 'cd_tipodocumento_secretario', $combotd, $selecttd,
                                  [
                                    'class'       => 'select2 form-control control input-xs combo' ,
                                    'id'          => 'cd_tipodocumento_secretario',
                                    'data-aw'     => '4'
                                  ]) !!}

                @include('error.erroresvalidate', [ 'id' => $errors->has('cd_tipodocumento_secretario')  , 
                                              'error' => $errors->first('cd_tipodocumento_secretario', ':message') , 
                                              'data' => '4'])
              </div>
            </div>

            <div class="col-sm-4">
              <div class="input-group my-group">
                  <label class="control-label"><b>Documento <small class="">(Secretario)</small> : </b></label>
                  <input  type="text"
                          id="cd_dni_secretario_apafa" name='cd_dni_secretario_apafa' 
                          value=""
                          value="{{ old('cd_dni_secretario_apafa') }}"                         
                          placeholder="DNI"
                          required = ""
                          maxlength="10"                     
                          autocomplete="off" class="form-control input-sm cd_dni_secretario_apafa" data-aw="5"/>
                  @include('error.erroresvalidate', [ 'id' => $errors->has('cd_dni_secretario_apafa')  , 
                                                'error' => $errors->first('cd_dni_secretario_apafa', ':message') , 
                                                'data' => '5'])

                    <span class="input-group-btn">
                      <button class="btn btn-primary btn-buscar_dni"
                              data_dni = 'cd_dni_secretario_apafa'
                              data_nombre = 'cd_nombre_secretario_apafa'
                              type="button" 
                              style="margin-top: 26px;height: 37px;">
                              Buscar Reniec</button>
                    </span>
              </div>
            </div>
            
            <div class="col-sm-5">
              <div class="form-group">
                <label class="control-label"><b>NOMBRES <small class="">(Secretario)</small> : </b></label>
                <input  type="text"
                        id="cd_nombre_secretario_apafa" name='cd_nombre_secretario_apafa' 
                        value=""
                        value="{{ old('cd_nombre_secretario_apafa') }}"                         
                        placeholder="NOMBRES"
                        required = ""
                        maxlength="300"                     
                        autocomplete="off" class="form-control input-sm cd_nombre_secretario_apafa" data-aw="6"/>
                @include('error.erroresvalidate', [ 'id' => $errors->has('cd_nombre_secretario_apafa')  , 
                                              'error' => $errors->first('cd_nombre_secretario_apafa', ':message') , 
                                              'data' => '6'])
              </div>
            </div>




            <div class="col-sm-3">

              <div class="form-group">
                <label class="control-label"><b>Tipo Documento <small class="">(Tesorero)</small> : </b></label>

                {!! Form::select( 'cd_tipodocumento_tesorero', $combotd, $selecttd,
                                  [
                                    'class'       => 'select2 form-control control input-xs combo' ,
                                    'id'          => 'cd_tipodocumento_tesorero',
                                    'data-aw'     => '4'
                                  ]) !!}

                @include('error.erroresvalidate', [ 'id' => $errors->has('cd_tipodocumento_tesorero')  , 
                                              'error' => $errors->first('cd_tipodocumento_tesorero', ':message') , 
                                              'data' => '4'])
              </div>
            </div>

            <div class="col-sm-4">
              <div class="input-group my-group">
                  <label class="control-label"><b>Documento <small class="">(Tesorero)</small> : </b></label>
                  <input  type="text"
                          id="cd_dni_tesorero_apafa" name='cd_dni_tesorero_apafa' 
                          value=""
                          value="{{ old('cd_dni_tesorero_apafa') }}"                         
                          placeholder="DNI"
                          required = ""
                          maxlength="10"                     
                          autocomplete="off" class="form-control input-sm cd_dni_tesorero_apafa" data-aw="5"/>
                  @include('error.erroresvalidate', [ 'id' => $errors->has('cd_dni_tesorero_apafa')  , 
                                                'error' => $errors->first('cd_dni_tesorero_apafa', ':message') , 
                                                'data' => '5'])

                    <span class="input-group-btn">
                      <button class="btn btn-primary btn-buscar_dni"
                              data_dni = 'cd_dni_tesorero_apafa'
                              data_nombre = 'cd_nombre_secretario_apafa'
                              type="button" 
                              style="margin-top: 26px;height: 37px;">
                              Buscar Reniec</button>
                    </span>
              </div>
            </div>
            
            <div class="col-sm-5">
              <div class="form-group">
                <label class="control-label"><b>NOMBRES <small class="">(Tesorero)</small> : </b></label>
                <input  type="text"
                        id="cd_nombre_tesorero_apafa" name='cd_nombre_tesorero_apafa' 
                        value=""
                        value="{{ old('cd_nombre_tesorero_apafa') }}"                         
                        placeholder="NOMBRES"
                        required = ""
                        maxlength="300"                     
                        autocomplete="off" class="form-control input-sm cd_nombre_tesorero_apafa" data-aw="6"/>
                @include('error.erroresvalidate', [ 'id' => $errors->has('cd_nombre_tesorero_apafa')  , 
                                              'error' => $errors->first('cd_nombre_tesorero_apafa', ':message') , 
                                              'data' => '6'])
              </div>
            </div>

            <div class="col-sm-3">

              <div class="form-group">
                <label class="control-label"><b>Tipo Documento <small class="">(Vocal 1)</small> : </b></label>

                {!! Form::select( 'cd_tipodocumento_vocal1', $combotd, $selecttd,
                                  [
                                    'class'       => 'select2 form-control control input-xs combo' ,
                                    'id'          => 'cd_tipodocumento_vocal1',
                                    'data-aw'     => '4'
                                  ]) !!}

                @include('error.erroresvalidate', [ 'id' => $errors->has('cd_tipodocumento_vocal1')  , 
                                              'error' => $errors->first('cd_tipodocumento_vocal1', ':message') , 
                                              'data' => '4'])
              </div>

            </div>

            <div class="col-sm-4">
              <div class="input-group my-group">
                  <label class="control-label"><b>Documento <small class="">(Vocal 1)</small> : </b></label>
                  <input  type="text"
                          id="cd_dni_vocal1_apafa" name='cd_dni_vocal1_apafa' 
                          value=""
                          value="{{ old('cd_dni_vocal1_apafa') }}"                         
                          placeholder="DNI"
                          required = ""
                          maxlength="10"                     
                          autocomplete="off" class="form-control input-sm cd_dni_vocal1_apafa" data-aw="5"/>
                  @include('error.erroresvalidate', [ 'id' => $errors->has('cd_dni_vocal1_apafa')  , 
                                                'error' => $errors->first('cd_dni_vocal1_apafa', ':message') , 
                                                'data' => '5'])

                    <span class="input-group-btn">
                      <button class="btn btn-primary btn-buscar_dni"
                              data_dni = 'cd_dni_vocal1_apafa'
                              data_nombre = 'cd_nombre_vocal1_apafa'
                              type="button" 
                              style="margin-top: 26px;height: 37px;">
                              Buscar Reniec</button>
                    </span>
              </div>
            </div>
            
            <div class="col-sm-5">
              <div class="form-group">
                <label class="control-label"><b>NOMBRES <small class="">(Vocal 1)</small> : </b></label>
                <input  type="text"
                        id="cd_nombre_vocal1_apafa" name='cd_nombre_vocal1_apafa' 
                        value=""
                        value="{{ old('cd_nombre_vocal1_apafa') }}"                         
                        placeholder="NOMBRES"
                        required = ""
                        maxlength="300"                     
                        autocomplete="off" class="form-control input-sm cd_nombre_vocal1_apafa" data-aw="6"/>
                @include('error.erroresvalidate', [ 'id' => $errors->has('cd_nombre_vocal1_apafa')  , 
                                              'error' => $errors->first('cd_nombre_vocal1_apafa', ':message') , 
                                              'data' => '6'])
              </div>
            </div>
      </fieldset>


      <fieldset>
        <legend>ARCHIVOS</legend>

            <div class="col-sm-6">
              <div>
                <label class="labelarchivos" for="uploadapafa">
                  <input type="file" id="uploadapafa" name='uploadapafa[]' accept=".doc,.docx,.xls,.xlsx,.pppt,.pptx,.pdf,image/*,video/*,.mp3,audio/wav,.txt" required>
                  Adjuntar la Resolución Directoral de reconocimiento de APAFA en formato PDF
                </label>
              </div>
              <div class="files filesapafa">
                <h4>Archivos Seleccionados</h4>
                <ul id='larchivosapafa' class="larchivosapafa"></ul>
                <input type="hidden" name="archivos" id='archivos' value="">
              </div>
            </div>


            <div class="col-sm-6">
              <div>
                <label class="labelarchivos" for="upload">
                  <input type="file" id="upload" name='upload[]' accept=".doc,.docx,.xls,.xlsx,.pppt,.pptx,.pdf,image/*,video/*,.mp3,audio/wav,.txt" required>
                  Adjuntar la Resolución Directoral de reconocimiento de CONEI en formato PDF
                </label>
              </div>
              <div class="files">
                <h4>Archivos Seleccionados</h4>
                <ul id='larchivos' class="larchivos"></ul>
                <input type="hidden" name="archivos" id='archivos' value="">
              </div>
            </div>
      </fieldset>





      <div class="row xs-pt-15">
        <div class="col-xs-6">
            <div class="be-checkbox">
            </div>
        </div>
        <div class="col-xs-6">
          <p class="text-right">
            <button type="submit" class="btn btn-space btn-primary">Guardar</button>
          </p>
        </div>
      </div>
    </div>
  </div>
</div>

