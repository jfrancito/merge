<div class="control-group">

  <div class="row">
    <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
        <div class="form-group">
          <label class="col-sm-12 control-label labelleft negrita" style="text-align: left;">TIPO DOCUMENTO :</label>
          <div class="col-sm-12 abajocaja" >
            <?php echo Form::select( 'tipodoc_id', $combo_tipodoc, array($tipodoc_id),
                              [
                                'class'       => 'select2 form-control control input-sm' ,
                                'id'          => 'tipodoc_id',
                                'required'    => ''
                              ]); ?>

          </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3 sectorplanilla ocultar">
      <div class="form-group">
          <label class="col-sm-12 control-label labelleft negrita" style="text-align: left;">BUSCAR : </label>
          <div class="col-sm-12 abajocaja" >
              <button type="button" data-dismiss="modal" class="btn btn-success btn-buscar-planilla"
              data_iddocumento="<?php echo e($liquidaciongastos->ID_DOCUMENTO); ?>"
              >BUSCAR PLANILLA</button>
              <input type="hidden" name="cod_planila" id ='cod_planila'>
              <input type="hidden" name="rutacompleta" id ='rutacompleta'>
              <input type="hidden" name="nombrearchivo" id ='nombrearchivo'>
          </div>
        </div>
    </div>

    <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3 sectorxml ocultar">
      <div class="form-group">

          <label class="col-sm-12 control-label labelleft negrita" style="text-align: left;">RESPUESTA XML : </label>
          <div class="col-sm-12 abajocaja" >
              <p style="margin:0px;"><b>Respuesta Sunat</b> : <strong class="MESSAGE"></strong></p>
              <p style="margin:0px;"><b>Estado Comprobante</b> : <strong class="NESTADOCP"></strong></p>
              <p style="margin:0px;"><b>Estado Ruc</b> : <strong class="NESTADORUC"></strong></p>
              <p style="margin:0px;"><b>Estado Domicilio</b> :<strong class="NCONDDOMIRUC"></strong></p>
              <p style="margin:0px;"><b>Pdf Sunat</b> :<strong class="PDFSUNAT"></strong></p>

              <input type="hidden" name="SUCCESS" id="SUCCESS" >
              <input type="hidden" name="MESSAGE" id="MESSAGE" >
              <input type="hidden" name="ESTADOCP" id="ESTADOCP" >
              <input type="hidden" name="NESTADOCP" id="NESTADOCP" >
              <input type="hidden" name="ESTADORUC" id="ESTADORUC" >
              <input type="hidden" name="NESTADORUC" id="NESTADORUC" >
              <input type="hidden" name="CONDDOMIRUC" id="CONDDOMIRUC" >
              <input type="hidden" name="NCONDDOMIRUC" id="NCONDDOMIRUC" >
              <input type="hidden" name="EMPRESAID" id="EMPRESAID" >
              <input type="hidden" name="NOMBREFILE" id="NOMBREFILE" >
              <input type="hidden" name="RUTACOMPLETA" id="RUTACOMPLETA" >
              <input type="hidden" name="RUTACOMPLETAPDF" id="RUTACOMPLETAPDF" >
              <input type="hidden" name="NOMBREPDF" id="NOMBREPDF" >
              <input type="hidden" name="PRIMERA_FECHA_RENDICION_DET" id = "PRIMERA_FECHA_RENDICION_DET" value = "<?php echo e($primerafechaar); ?>">
              <input type="hidden" name="ULTIMA_FECHA_RENDICION_DET" id = "ULTIMA_FECHA_RENDICION_DET" value = "<?php echo e($ultimafecha); ?>">



              <input type="hidden" name="array_detalle_producto" id='array_detalle_producto' value=''>
          </div>

          <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 negrita" align="center">
              <button  type="button" class="btn btn-space btn-success btn-lg validarxml" id='validarxml' title="Cargar Datos">Validar</button>
          </div>

          <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 negrita" align="center" style="    margin-left: 16px;">
              <button  type="button" class="btn btn-space btn-primary btn-lg limpiarxml" id='limpiarxml'>Limpiar</button>
          </div>

          <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 negrita" align="center" style="    margin-left: 18px;">
              <button  type="button" class="btn btn-space btn-success btn-lg traerpdf" id='traerpdf'>PDF Sunat</button>
          </div>


        </div>
    </div>
  </div>
  <div class="row" style="margin-top:10px;">
    <div class="ol-xs-12 col-sm-4 col-md-3 col-lg-3">
      <div class="form-group">
        <label class="col-sm-12 control-label labelleft negrita">SERIE :</label>
        <div class="col-sm-12">
            <input  type="text"
                    id="serie" name='serie' 
                    value="<?php if(count($tdetliquidacionitem)>0): ?><?php echo e(old('serie' ,$tdetliquidacionitem->SERIE)); ?><?php else: ?><?php echo e(old('serie')); ?><?php endif; ?>"                         
                    placeholder="SERIE"
                    maxlength="4"
                    required = ""
                    autocomplete="off" class="form-control input-sm validarmayusculas"/>

        </div>
      </div>
    </div>

    <div class="ol-xs-12 col-sm-4 col-md-3 col-lg-3">
      <div class="form-group">
        <label class="col-sm-12 control-label labelleft negrita">NUMERO :</label>
        <div class="col-sm-12">
            <input  type="text"
                    id="numero" name='numero' 
                    value="<?php if(count($tdetliquidacionitem)>0): ?><?php echo e(old('numero' ,$tdetliquidacionitem->NUMERO)); ?><?php else: ?><?php echo e(old('numero')); ?><?php endif; ?>"                         
                    placeholder="NUMERO"
                    maxlength="10"
                    required = ""
                    autocomplete="off" class="form-control input-sm"/>


        </div>
      </div>
    </div>

    <div class="ol-xs-12 col-sm-4 col-md-3 col-lg-3">
      <div class="form-group">
        <label class="col-sm-12 control-label labelleft negrita">FECHA EMISION :</label>
        <div class="col-sm-12">
            <div data-min-view="2" 
                   data-date-format="dd-mm-yyyy"  
                   class="input-group date datetimepicker pickerfecha pickerfechadet" style = 'padding: 0px 0;margin-top: -3px;'>
                   <input size="16" type="text" 
                          placeholder="FECHA DE EMISION"
                          id='fecha_emision' 
                          name='fecha_emision' 
                          required = ""
                          value="<?php if(count($tdetliquidacionitem)>0): ?><?php echo e(old('fecha_emision' ,$tdetliquidacionitem->FECHA_EMISION)); ?><?php else: ?><?php echo e(old('fecha_emision')); ?><?php endif; ?>" 
                          class="form-control input-sm"/>
                    <span class="input-group-addon btn btn-primary"><i class="icon-th mdi mdi-calendar"></i></span>
              </div>

        </div>
      </div>
    </div>
    <div class="ol-xs-12 col-sm-4 col-md-3 col-lg-3">
      <div class="form-group">
        <label class="col-sm-12 control-label labelleft negrita">TOTAL :</label>
        <div class="col-sm-12">
            <input  type="text"
                    id="totaldetalle" name='totaldetalle' 
                    value="<?php if(count($tdetliquidacionitem)>0): ?><?php echo e(old('totaldetalle' ,$tdetliquidacionitem->TOTAL)); ?><?php else: ?><?php echo e(old('totaldetalle')); ?><?php endif; ?>"                     
                    placeholder="TOTAL"
                    readonly = "readonly"
                    autocomplete="off" class="form-control input-sm"/>
        </div>
      </div>
    </div>
  </div>
  <div class="row" style="margin-top:10px;">

    <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
        <div class="form-group">
          <label class="col-sm-12 control-label labelleft negrita" style="text-align: left;">EMPRESA :</label>
          <div class="col-sm-12 abajocaja" >
              <?php echo Form::select( 'empresa_id', $combo_empresa, array($empresa_id),
                                [
                                  'class'       => 'select2 form-control control ' ,
                                  'id'          => 'empresa_id',
                                  'required'    => ''
                                ]); ?>

          </div>
        </div>
    </div>

    <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3 ajax_combo_cuenta">
        <?php echo $__env->make('general.ajax.combocuenta', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>

    <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3 ajax_combo_subcuenta">
        <?php echo $__env->make('general.ajax.combosubcuenta', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>

    <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
      <div class="form-group">
        <label class="col-sm-12 control-label labelleft negrita">GLOSA :</label>
          <div class="col-sm-12">
              <textarea 
              name="glosadet"
              id = "glosadet"
              class="form-control input-sm validarmayusculas"
              rows="2"><?php if(count($tdetliquidacionitem)>0): ?><?php echo e(old('glosadet' ,$tdetliquidacionitem->TXT_GLOSA)); ?><?php else: ?><?php echo e(old('glosadet')); ?><?php endif; ?></textarea>
          </div>
      </div>
    </div>
  </div>
  <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
      <div class="form-group">
        <label class="col-sm-12 control-label labelleft negrita" style="text-align: left;">COSTO :</label>
        <div class="col-sm-12 abajocaja" >
          <?php echo Form::select( 'costo_id', $combo_costo, array($costo_id),
                            [
                              'class'       => 'select2 form-control control input-sm' ,
                              'id'          => 'costo_id',
                              'required'    => '',
                            ]); ?>

        </div>
      </div>
  </div>

  <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3 sectorxml sectorotrotipo ocultar">
    <div class="form-group">
      <label class="col-sm-12 control-label labelleft negrita" >PRODUCTO <span class="obligatorio">(*)</span> :</label>
      <div class="col-sm-12">
          <?php echo Form::select( 'producto_id_factura', $comboproducto, $producto_id,
                              [
                                'class'       => 'select2 form-control control input-xs' ,
                                'id'          => 'producto_id_factura',        
                              ]); ?>

      </div>
    </div>
  </div>

  <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3 sectorxml sectorotrotipo ocultar">
    <div class="form-group">
      <label class="col-sm-12 control-label labelleft negrita" >¿ESTA AFECTO A IGV?<span class="obligatorio">(*)</span> :</label>
      <div class="col-sm-12">
          <?php echo Form::select( 'igv_id_factura', $combo_igv, array($igv_id),
                              [
                                'class'       => 'select2 form-control control input-xs' ,
                                'id'          => 'igv_id_factura',        
                              ]); ?>

      </div>
    </div>
  </div>


</div>
<div class="row sectorxmlmodal ocultar" style="margin-top:25px;">
  <table id="tdxml" class="table table-striped table-hover" style='width: 100%;'>
    <thead>
      <tr>
        <th>DETALLE DEL DOCUMENTO</th> 
      </tr>
    </thead>
    <tbody>

    </tbody>
  </table>
</div>
<div class="row sectorxmlmodal ocultar" style="margin-top:25px;">
    <?php $__currentLoopData = $tarchivos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
        <?php 
            $extension = $item->COD_CTBLE;
            if ($extension == 'ZIP') {
                $extension = 'XML';
            }
         ?>
        <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3 <?php echo e($item->COD_CATEGORIA); ?>">
          <div class="form-group sectioncargarimagen">
            <label class="col-sm-12 control-label" style="text-align: left;">
              <div class="tooltipfr"><b><?php echo e($item->NOM_CATEGORIA); ?> (<?php echo e($extension); ?>)</b>
              </div>
            </label>
              <div class="col-sm-12">
                  <div class="file-loading">
                      <input 
                      id="file-<?php echo e($item->COD_CATEGORIA); ?>" 
                      name="<?php echo e($item->COD_CATEGORIA); ?>[]" 
                      class="file-es"  
                      type="file" 
                      multiple data-max-file-count="1">
                  </div>
              </div>
          </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<?php if(count($tdetliquidacionitem)>0): ?> 
  <?php if(!in_array($tdetliquidacionitem->COD_TIPODOCUMENTO, ['TDO0000000000070','TDO0000000000001','TDO0000000000003','TDO0000000000010'])): ?>
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: right;margin-top: 13px;margin-bottom: 13px;">
    <button 
          type="button" 
          data-dismiss="modal" 
          class="btn btn-success btn-agregar-detalle-factura"
          data_iddocumento="<?php echo e($tdetliquidacionitem->ID_DOCUMENTO); ?>"
          data_item="<?php echo e($tdetliquidacionitem->ITEM); ?>"
    >AGREGAR DETALLE</button>
  </div>
  <?php endif; ?>
<?php else: ?>
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: right;margin-top: 13px;margin-bottom: 13px;">
    <button type="button" data-dismiss="modal" class="btn btn-success btn-guardar-detalle-factura">GUARDAR PARA AGREGAR DOCUMENTO</button>
  </div>
<?php endif; ?>
<div class="col-xs-12">
  <table id="tdpm" class="table table-striped table-striped  nowrap listatabla ltabladet" style='width: 100%;'>
    <thead>
      <tr>
        <th>DETALLE DEL DOCUMENTO</th> 
      </tr>
    </thead>
    <tbody>
      <?php $__currentLoopData = $tdetdocliquidacionitem; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
          <td class="cell-detail" style="position: relative;">
            <span style="display: block;"><b>COD_PRODUCTO : </b> <?php echo e($item->COD_PRODUCTO); ?></span>
            <span style="display: block;"><b>PRODUCTO : </b> <?php echo e($item->TXT_PRODUCTO); ?></span>
            <span style="display: block;"><b>CANTIDAD : </b> <?php echo e($item->CANTIDAD); ?></span>
            <span style="display: block;"><b>PRECIO : </b> <?php echo e($item->PRECIO); ?></span>
            <span style="display: block;"><b>IND IGV : </b> <?php if($item->IND_IGV==1): ?> SI <?php else: ?> NO <?php endif; ?></span>
            <span style="display: block;"><b>SUBTOTAL : </b> <?php echo e($item->SUBTOTAL); ?></span>
            <span style="display: block;"><b>IGV : </b> <?php echo e($item->IGV); ?></span>
            <span style="display: block;"><b>TOTAL : </b> <?php echo e($item->TOTAL); ?></span>
            <?php if(!in_array($tdetliquidacionitem->COD_TIPODOCUMENTO, ['TDO0000000000070','TDO0000000000001','TDO0000000000003','TDO0000000000010'])): ?>
              <button type="button" data_iddocumento = "<?php echo e($item->ID_DOCUMENTO); ?>" data_item = "<?php echo e($item->ITEM); ?>" data_item_documento = "<?php echo e($item->ITEMDOCUMENTO); ?>" style="margin-top: 5px;float: right;" class="btn btn-rounded btn-space btn-success btn-sm modificardetalledocumentolg">MODIFICAR</button>
            <?php endif; ?>
          </td>
        </tr>                    
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
  </table>
</div>
<?php if(count($tdetliquidacionitem)>0): ?>
<div class="col-lg-12">

  <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
    <div class="panel panel-default panel-contrast">
      <div class="panel-heading" style="background: #1d3a6d;color: #fff;">ARCHIVOS
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
              <?php $__currentLoopData = $archivos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>  
                <tr>
                  <td><?php echo e($index + 1); ?></td>
                  <td><?php echo e($item->DESCRIPCION_ARCHIVO); ?></td>
                  <td><?php echo e($item->NOMBRE_ARCHIVO); ?></td>
                  <td class="rigth">
                    <div class="btn-group btn-hspace">
                      <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Acción <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
                      <ul role="menu" class="dropdown-menu pull-right">
                        <li>
                          <a href="<?php echo e(url('/descargar-archivo-requerimiento-lg/'.$item->TIPO_ARCHIVO.'/'.$idopcion.'/'.$item->DOCUMENTO_ITEM.'/'.$item->ID_DOCUMENTO)); ?>">
                            Descargar
                          </a>  
                        </li>                       
                      </ul>
                    </div>
                  </td>
                </tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>



<?php if(isset($ajax)): ?>
  <script type="text/javascript">
    $(document).ready(function(){
       App.dataTables();
    });
  </script> 
<?php endif; ?>









</div>



