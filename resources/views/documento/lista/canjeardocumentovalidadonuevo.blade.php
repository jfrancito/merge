<div class="listadatos">  
        <div class="container">

          <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
              <div class="panel panel-default panel-contrast">
                <div class="panel-heading" style="background: #1d3a6d;color: #fff;">DOCUMENTOS OSIRIS
                </div>
                <div class="panel-body panel-body-contrast">


                          <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 cajareporte">
                              <div class="form-group">
                                <label class="col-sm-12 control-label labelleft" >Tipo Documento :</label>
                                <div class="col-sm-12 abajocaja" >
                                  {!! Form::select( 'tipodoc_id', $combo_tipodoc, array($tipodoc_id),
                                                    [
                                                      'class'       => 'select2 form-control control input-sm' ,
                                                      'id'          => 'tipodoc_id',
                                                      'required'    => '',
                                                      'data-aw'     => '1',
                                                    ]) !!}
                                </div>
                              </div>
                          </div> 


                          <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 cajareporte">
                              <div class="form-group">
                                <label class="col-sm-12 control-label labelleft" >Centro :</label>
                                <div class="col-sm-12 abajocaja" >
                                  {!! Form::select( 'centro_id', $combo_centro, array($centro_id),
                                                    [
                                                      'class'       => 'select2 form-control control input-sm' ,
                                                      'id'          => 'centro_id',
                                                      'required'    => '',
                                                      'data-aw'     => '1',
                                                    ]) !!}
                                </div>
                              </div>
                          </div>


                          <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 cajareporte">
                              <div class="form-group">
                                <label class="col-sm-12 control-label labelleft" >Empresa :</label>
                                <div class="col-sm-12 abajocaja" >
                                  {!! Form::select( 'empresa_id', $combo_empresa, array($empresa_id),
                                                    [
                                                      'class'       => 'select2 form-control control input-sm' ,
                                                      'id'          => 'empresa_id',
                                                      'required'    => '',
                                                      'data-aw'     => '1',
                                                    ]) !!}
                                </div>
                              </div>
                          </div> 



                          <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 cajareporte">
                              <div class="form-group">
                                <label class="col-sm-12 control-label labelleft" >Tipo Servicio :</label>
                                <div class="col-sm-12 abajocaja" >
                                  {!! Form::select( 'tiposervicio_id', $combo_tiposervicio, array($tiposervicio_id),
                                                    [
                                                      'class'       => 'select2 form-control control input-sm' ,
                                                      'id'          => 'tiposervicio_id',
                                                      'required'    => '',
                                                      'data-aw'     => '1',
                                                    ]) !!}
                                </div>
                              </div>
                          </div> 



                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 cajareporte">
                                <div class="form-group ">
                                  <label class="col-sm-12 control-label labelleft" >Fecha Inicio:</label>
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

                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 cajareporte">
                              <div class="form-group ">
                                <label class="col-sm-12 control-label labelleft" >Fecha Fin:</label>
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


                            <div class="row xs-pt-15" style="margin-top:20px;">
                              <div class="col-xs-6">
                                  <div class="be-checkbox">

                                  </div>
                              </div>
                              <div class="col-xs-6" style="margin-top:15px;">
                                <p class="text-right">
                                  <button type="submit" class="btn btn-space btn-primary buscardocumenoosiris">Buscar</button>
                                </p>
                              </div>
                            </div>


                </div>
              </div>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
              <div class="panel panel-default panel-contrast">
                <div class="panel-heading background-amarillo" style="color: #000;">DOCUMENTOS MERGE
                </div>
                <div class="panel-body panel-body-contrast">

                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 cajareporte">
                                <div class="form-group ">
                                  <label class="col-sm-12 control-label labelleft" >Fecha Inicio:</label>
                                  <div class="col-sm-12 abajocaja" >
                                    <div data-min-view="2" 
                                           data-date-format="dd-mm-yyyy"  
                                           class="input-group date datetimepicker pickerfecha" style = 'padding: 0px 0;margin-top: -3px;'>
                                           <input size="16" type="text" 
                                                  value="{{$fecha_inicio}}" 
                                                  placeholder="Fecha Inicio"
                                                  id='fecha_inicio_m' 
                                                  name='fecha_inicio_m' 
                                                  required = ""
                                                  class="form-control input-sm"/>
                                            <span class="input-group-addon btn btn-primary"><i class="icon-th mdi mdi-calendar"></i></span>
                                      </div>
                                  </div>
                                </div>
                            </div> 

                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 cajareporte">
                              <div class="form-group ">
                                <label class="col-sm-12 control-label labelleft" >Fecha Fin:</label>
                                <div class="col-sm-12 abajocaja" >
                                  <div data-min-view="2" 
                                         data-date-format="dd-mm-yyyy"  
                                         class="input-group date datetimepicker pickerfecha" style = 'padding: 0px 0;margin-top: -3px;'>
                                         <input size="16" type="text" 
                                                value="{{$fecha_fin}}" 
                                                placeholder="Fecha Fin"
                                                id='fecha_fin_m' 
                                                name='fecha_fin_m' 
                                                required = ""
                                                class="form-control input-sm"/>
                                          <span class="input-group-addon btn btn-primary"><i class="icon-th mdi mdi-calendar"></i></span>
                                    </div>
                                </div>
                              </div>
                            </div> 


                            <div class="row xs-pt-15" style="margin-top:20px;">
                              <div class="col-xs-6">
                                  <div class="be-checkbox">

                                  </div>
                              </div>
                              <div class="col-xs-6" style="margin-top:15px;">
                                <p class="text-right">
                                  <button type="submit" class="btn btn-space btn-primary buscardocumentosmerge">Buscar</button>
                                </p>
                              </div>
                            </div>


                </div>
              </div>
            </div>


          </div>



          <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
              <div class="panel panel-default panel-contrast">
                
                <div class="panel-heading" style="background: #1d3a6d;color: #fff;">DOCUMENTOS SELECCIONADO
                </div>
                <div class="panel-body panel-body-contrast">

                    <div class='listajax_osiris'>
                        @include('documento.ajax.adocumentososiris')
                    </div>

                </div>
              </div>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
              <div class="panel panel-default panel-contrast">
                <div class="panel-heading background-amarillo" style="color: #000;">DOCUMENTOS SELECCIONADO
                </div>
                <div class="panel-body panel-body-contrast">

                    <div class='listajax_merge'>
                        @include('documento.ajax.adocumentosmerge')
                    </div>


                </div>
              </div>
            </div>


          </div>





        </div>
</div>


