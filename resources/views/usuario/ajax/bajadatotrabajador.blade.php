@if (count($trabajador)>0) 

		@if (($trabajador->activo)==1) 

				<div class="row">
					<div class="col-sm-6 ">
						<div class="panel-body">

							<div class="form-group">
								<label class="col-sm-3 control-label labelleft">Nombre</label>
								<div class="col-sm-5 abajocaja">

								  <input  type="text"
								          id="nombre" name='nombre' value='{{$trabajador->nombres}}'  placeholder="Nombre del Trabajador"
								          required = "" disabled="disabled"
								          autocomplete="off" class="form-control input-sm" data-aw="1"/>

								</div>

								<input  type="hidden"
								          id="trabajador_id" name='trabajador_id' value = '{{$trabajador->id}}'/>
							</div> 

							<div class="form-group">
								<label class="col-sm-3 control-label labelleft">Apellido Paterno</label>
								<div class="col-sm-5 abajocaja">

								  <input  type="text"
								          id="apellidopaterno" name='apellidopaterno' value='{{$trabajador->apellidopaterno}}'  placeholder="Apellido del Trabajador"
								          required = "" disabled="disabled"
								          autocomplete="off" class="form-control input-sm" data-aw="1"/>

								</div>

							</div> 

							<div class="form-group">
								<label class="col-sm-3 control-label labelleft">Apellido Materno</label>
								<div class="col-sm-5 abajocaja">

								  <input  type="text"
								          id="apellidomaterno" name='apellidomaterno' value='{{$trabajador->apellidomaterno}}'  placeholder="Apellido del Trabajador"
								          required = "" disabled="disabled"
								          autocomplete="off" class="form-control input-sm" data-aw="1"/>

								</div>

							</div> 

						</div> 
					</div> 

			      	<div class="col-sm-6 ">
			          <div class="panel-body">

			             <div class="form-group">

			                  <label class="col-sm-3 control-label labelleft">Situación</label>
			                  <div class="col-sm-5 abajocaja">
			                    {!! Form::select( 'situacion_id', $combosituacion, array(),
			                                      [
			                                        'class'       => 'form-control control input-sm' ,
			                                        'id'          => 'situacion_id',
			                                        'required'    => '',
			                                        'data-aw'     => '28'
			                                      ]) !!}
			                  </div>
			              </div>

			              <div class="form-group">
				                <label class="col-sm-3 control-label labelleft">Motivo Baja</label>
				                <div class="col-sm-5 abajocaja">
				                  {!! Form::select( 'motivobaja_id', $combomotivobaja, array(),
				                                    [
				                                      'class'       => 'form-control control input-sm' ,
				                                      'id'          => 'motivobaja_id',
				                                      'required'    => '',
				                                      'data-aw'     => '26'
				                                    ]) !!}
				                </div>
			              </div>
			          </div>
			      	</div>
			    </div>
		@else

				<div class="row">
						<div class="col-sm-6 ">
							<div class="panel-body">

								<div class="form-group">
									<label class="col-sm-3 control-label labelleft">Nombre</label>
									<div class="col-sm-5 abajocaja"> 

									  <input  type="text"
									          id="nombre" name='nombre' value=''  placeholder="Nombre del Trabajador"
									          required = "" disabled="disabled"
									          autocomplete="off" class="form-control input-sm" data-aw="1"/>

									</div>

									<input  type="hidden"
									          id="trabajador_id" name='trabajador_id' value = '{{$trabajador->id}}'/>
								</div> 

								<div class="form-group">
									<label class="col-sm-3 control-label labelleft">Apellido Paterno</label>
									<div class="col-sm-5 abajocaja">

									  <input  type="text"
									          id="apellidopaterno" name='apellidopaterno' value=''  placeholder="Apellido del Trabajador"
									          required = "" disabled="disabled"
									          autocomplete="off" class="form-control input-sm" data-aw="1"/>

									</div>

	
								</div> 

								<div class="form-group">
									<label class="col-sm-3 control-label labelleft">Apellido Materno</label>
									<div class="col-sm-5 abajocaja">

									  <input  type="text"
									          id="apellidomaterno" name='apellidomaterno' value=''  placeholder="Apellido del Trabajador"
									          required = "" disabled="disabled"
									          autocomplete="off" class="form-control input-sm" data-aw="1"/>

									</div>

								</div> 

							</div> 
						</div> 

				      	<div class="col-sm-6 ">
				          <div class="panel-body">

				             <div class="form-group">

				                  <label class="col-sm-3 control-label labelleft">Situación</label>
				                  <div class="col-sm-5 abajocaja">
				                    {!! Form::select( 'situacion_id', $combosituacion, array(),
				                                      [
				                                        'class'       => 'form-control control input-sm' ,
				                                        'id'          => 'situacion_id',
				                                        'required'    => '',
				                                        'data-aw'     => '28'
				                                      ]) !!}
				                  </div>
				              </div>

				              <div class="form-group">
					                <label class="col-sm-3 control-label labelleft">Motivo Baja</label>
					                <div class="col-sm-5 abajocaja">
					                  {!! Form::select( 'motivobaja_id', $combomotivobaja, array(),
					                                    [
					                                      'class'       => 'form-control control input-sm' ,
					                                      'id'          => 'motivobaja_id',
					                                      'required'    => '',
					                                      'data-aw'     => '26'
					                                    ]) !!}
					                </div>
				              </div>
				          </div>
				      	</div>
				</div>

				@include('error.erroresajax', ['error' => 'Trabajador '.$trabajador->nombres.' '.$trabajador->apellidopaterno.' '. $trabajador->apellidomaterno.'  Ya está de BAJA']) 

		@endif

@else 


	<div class="row">
		<div class="col-sm-6 ">
			<div class="panel-body">

				<div class="form-group">
					<label class="col-sm-3 control-label labelleft">Nombre</label>
					<div class="col-sm-5 abajocaja">


					  <input  type="text"
					          id="nombre" name='nombre'  placeholder="Nombre del Trabajador"
					          required = "" disabled="disabled"
					          autocomplete="off" class="form-control input-sm" data-aw="1"/>

					</div>

					<input  type="hidden"
					          id="trabajador_id" name='trabajador_id'/>			       
				</div>

				<div class="form-group">
					<label class="col-sm-3 control-label labelleft">Apellido Paterno</label>
					<div class="col-sm-5 abajocaja">

					  <input  type="text"
					          id="apellidopaterno" name='apellidopaterno'  placeholder="Apellido Paterno"
					          required = "" disabled="disabled"
					          autocomplete="off" class="form-control input-sm" data-aw="1"/>

					</div>

				</div>

				<div class="form-group">
					<label class="col-sm-3 control-label labelleft">Apellido Materno</label>
					<div class="col-sm-5 abajocaja">

					  <input  type="text"
					          id="apellidomaterno" name='apellidomaterno'  placeholder="Apellido Materno"
					          required = "" disabled="disabled"
					          autocomplete="off" class="form-control input-sm" data-aw="1"/>

					</div>
				</div> 
                
               
			</div> 
		</div> 

		<div class="col-sm-6 ">
	                <div class="panel-body">

	                     <div class="form-group">

	                          <label class="col-sm-3 control-label labelleft">Situación</label>
	                          <div class="col-sm-5 abajocaja">
	                            {!! Form::select( 'situacion_id', $combosituacion, array(),
	                                              [
	                                                'class'       => 'form-control control input-sm' ,
	                                                'id'          => 'situacion_id',
	                                                'required'    => '',
	                                                'data-aw'     => '28'
	                                              ]) !!}
	                          </div>
	                      </div>

	                      <div class="form-group">

	                        <label class="col-sm-3 control-label labelleft">Motivo Baja</label>
	                        <div class="col-sm-5 abajocaja">
	                          {!! Form::select( 'motivobaja_id', $combomotivobaja, array(),
	                                            [
	                                              'class'       => 'form-control control input-sm' ,
	                                              'id'          => 'motivobaja_id',
	                                              'required'    => '',
	                                              'data-aw'     => '26'
	                                            ]) !!}
	                        </div>
	                      </div>
	                </div>
	    </div>
	</div>


    @include('error.erroresajax', ['error' => 'Trabajador no existe']) 

@endif

