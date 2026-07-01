<div class="listadatos">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                <div class="panel panel-default panel-contrast">
                    <div class="panel-heading" style="background: #1d3a6d;color: #fff;">CARGAR DOCUMENTO XML
                    </div>
                    <div class="panel-body panel-body-contrast">
                        <form method="POST"
                              action="<?php echo e(url('subir-xml-cargar-datos-comision-administrator/'.$idopcion.'/'.$idoc)); ?>"
                              name="formcargardatos" id="formcargardatos" enctype="multipart/form-data">
                            <?php echo e(csrf_field()); ?>

                            <input type="hidden" name="device_info" id='device_info'>
                            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 cajareporte">

                                <div class="form-group">
                                    <label class="col-sm-12 control-label labelleft">Documento :</label>
                                    <div class="col-sm-12 abajocaja">
                                        <?php echo Form::select( 'documento_id', $combodocumento, array($documento_id),
                                                          [
                                                            'class'       => 'select2 form-control control input-sm' ,
                                                            'id'          => 'documento_id',
                                                            'required'    => '',
                                                            'data-aw'     => '1',
                                                          ]); ?>

                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="operacion_id" id="operacion_id"
                                   value="<?php echo e($fereftop1->OPERACION); ?>">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label labelleft">Archivo :</label>
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-10 negrita" align="left">
                                        <input name="inputxml" id='inputxml' class="form-control inputxml" type="file"
                                               accept="text/xml"/>
                                    </div>
                                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 negrita" align="center">
                                        <button type="submit" style="height:48px;"
                                                class="btn btn-space btn-success btn-lg cargardatosliq"
                                                id='cargardatosliq' title="Cargar Datos"><i
                                                    class="icon icon-left mdi mdi-upload"></i> Subir
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4" >
                <div class="panel panel-default panel-contrast">
                    <div class="panel-heading" style="background: #1d3a6d;color: #fff;">CONSULTA API SUNAT
                    </div>
                    <div class="panel-body panel-body-contrast">
                        <?php if(count($fedocumento)<=0): ?>
                            <div class="col-sm-12">
                                <b>CARGAR XML</b>
                            </div>
                        <?php else: ?>
                            <div class="col-sm-12">
                                <p style="margin:0px;"><b>Respuesta Sunat</b> : <?php echo e($fedocumento->message); ?></p>
                                <p style="margin:0px;"
                                   class='<?php if($fedocumento->estadoCp == 1): ?> msjexitoso <?php else: ?> msjerror <?php endif; ?>'><b>Estado
                                        Comprobante</b> :
                                    <?php echo e($fedocumento->nestadoCp); ?>

                                </p>
                                <p style="margin:0px;"><b>Estado Ruc</b> : <?php echo e($fedocumento->nestadoRuc); ?></p>
                                <p style="margin:0px;"><b>Estado Domicilio</b> : <?php echo e($fedocumento->ncondDomiRuc); ?></p>
                                <p style="margin:0px;"><b>Respuesta CDR</b> : <?php echo e($fedocumento->RESPUESTA_CDR); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                <div class="panel panel-default panel-contrast">
                    <div class="panel-heading" style="background: #1d3a6d;color: #fff;">DOCUMENTOS ASOCIADOS
                        <?php echo e(number_format($documento_asociados->sum('MONTOATENDIDOREAL'), 2, '.', ',')); ?>

                    </div>
                    <div class="panel-body panel-body-contrast">

                        <table class="table table-condensed table-striped">
                            <thead>
                            <tr>
                                <th>Item</th>
                                <th>ID</th>
                                <th>BANCO</th>
                                <th>CUENTA</th>
                                <th>TOTAL</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $documento_asociados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($index + 1); ?></td>
                                    <td><?php echo e($item->COD_OPERACION_CAJA); ?></td>
                                    <td><?php echo e($item->NOMBRE_BANCO_CAJA); ?></td>
                                    <td><?php echo e($item->NRO_CUENTA_BANCARIA); ?></td>
                                    <td><?php echo e($item->MONTOATENDIDOREAL); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>


        <?php if(count($fedocumento)>0): ?>
            <form method="POST" action="<?php echo e(url('validar-xml-oc-comision-administrator/'.$idopcion.'/'.$idoc)); ?>"
                  name="formguardardatos" id="formguardardatos" enctype="multipart/form-data">
                <?php echo e(csrf_field()); ?>

                <input type="hidden" name="device_info" id='device_info'>

                <input type="hidden" name="rutaorden" id='rutaorden' value='<?php echo e($rutaorden); ?>'>
                
                <div class="row">

                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                        <div class="panel panel-default panel-contrast">
                            <div class="panel-heading"
                                 style="background: #1d3a6d;color: #fff;"><?php echo e($fereftop1->OPERACION); ?>

                            </div>
                            <div class="panel-body panel-body-contrast">
                                <table class="table table-condensed table-striped">
                                    <thead>
                                    <tr>
                                        <th>VALOR</th>
                                        <th>DOCUMENTO</th>
                                        <th>XML</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <tr>
                                        <td><b>RUC</b></td>
                                        <td><p class='subtitulomerge'><?php echo e($documento_top->RUC); ?></p></td>
                                        <td class="">
                                            <div class='subtitulomerge <?php if($fedocumento->ind_ruc == 1): ?> msjexitoso <?php else: ?> msjerror <?php endif; ?>'>
                                                <b><?php echo e($fedocumento->RUC_PROVEEDOR); ?></b>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td><b>Moneda</b></td>
                                        <td><p class='subtitulomerge'><?php echo e($documento_top->MONEDA); ?></p></td>
                                        <td>
                                            <div class='subtitulomerge <?php if($fedocumento->ind_moneda == 1): ?> msjexitoso <?php else: ?> msjerror <?php endif; ?>'>
                                                <b>
                                                    <?php if($fedocumento->MONEDA == 'PEN'): ?>
                                                        SOLES
                                                    <?php else: ?>
                                                        <?php echo e($fedocumento->MONEDA); ?>

                                                    <?php endif; ?></b>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Total</b></td>
                                        <td>
                                            <p class='subtitulomerge'><?php echo e(number_format($documento_asociados->sum('MONTOATENDIDOREAL'), 4, '.', ',')); ?></p>
                                        </td>
                                        <td>
                                            <div class='subtitulomerge <?php if($fedocumento->ind_total == 1): ?> msjexitoso <?php else: ?> msjerror <?php endif; ?>'>
                                                <b><?php echo e(number_format($fedocumento->TOTAL_VENTA_ORIG, 4, '.', ',')); ?></b>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-8 col-lg-8">
                        <div class="panel panel-default panel-contrast">
                            <div class="panel-heading" style="background: #1d3a6d;color: #fff;">INFORMACION DEL XML
                            </div>
                            <div class="panel-body panel-body-contrast">

                                <div class="tab-container">
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a href="#xml" data-toggle="tab">XML</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div id="xml" class="tab-pane active cont">
                                            <table class="table table-condensed table-striped">
                                                <thead>
                                                <tr>
                                                    <th>Serie</th>
                                                    <th>Numero</th>
                                                    <th>Fecha Emision</th>
                                                    <th>Forma Pago</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td><?php echo e($fedocumento->SERIE); ?></td>
                                                    <td><?php echo e($fedocumento->NUMERO); ?></td>
                                                    <td><?php echo e($fedocumento->FEC_VENTA); ?></td>
                                                    <td><?php echo e($fedocumento->FORMA_PAGO); ?></td>
                                                </tr>
                                                </tbody>
                                            </table>


                                            <table class="table table-condensed table-striped">
                                                <thead>
                                                <tr>
                                                    <th>Codigo Producto</th>
                                                    <th>Nombre Producto</th>
                                                    <th>Unidad</th>
                                                    <th>Cantidad</th>
                                                    <th>Precio</th>
                                                    <th>Total</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php $__currentLoopData = $detallefedocumento; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td><?php echo e($item->CODPROD); ?></td>
                                                        <td><?php echo e($item->PRODUCTO); ?></td>
                                                        <td><?php echo e($item->UND_PROD); ?></td>
                                                        <td><?php echo e(number_format($item->CANTIDAD, 4, '.', ',')); ?></td>
                                                        <td><?php echo e(number_format($item->PRECIO_ORIG, 4, '.', ',')); ?></td>
                                                        <td><?php echo e(number_format($item->VAL_VENTA_ORIG, 4, '.', ',')); ?></td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </tbody>
                                            </table>


                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="panel panel-default panel-contrast">
                            <div class="panel-heading" style="background: #1d3a6d;color: #fff;">SUBIR ARCHIVOS
                            </div>
                            <div class="panel-body panel-body-contrast">

                                <div class="row">
                                    <?php if($rutaorden != ''): ?>
                                        <div><b>LOS ARCHIVOS DE CONTRATOS Y GUIAS RELACIONADAS SE CARGARAN DESPUES DE
                                                GUARDAR</b></div><br>
                                    <?php endif; ?>
                                    <?php $__currentLoopData = $tarchivos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($item->COD_CATEGORIA_DOCUMENTO != 'DCC0000000000048'): ?>
                                            <?php if($item->COD_CATEGORIA_DOCUMENTO == 'DCC0000000000026'): ?>
                                                <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3" style="margin-top:15px;">
                                                    <label class="col-sm-12 control-label"
                                                           style="text-align: left; height: 50px;"><b><?php echo e($item->NOM_CATEGORIA_DOCUMENTO); ?>

                                                            (<?php echo e($item->TXT_FORMATO); ?>)</b>
                                                        <?php if($item->COD_CATEGORIA_DOCUMENTO == 'DCC0000000000005'): ?>
                                                            <b>(Descargue el pdf de este enlace <a
                                                                        href="https://e-consultaruc.sunat.gob.pe/cl-ti-itmrconsruc/FrameCriterioBusquedaWeb.jsp"
                                                                        target="_blank">Sunat</a> y subalo para que pueda
                                                                aprobar</b>)
                                                        <?php endif; ?> </label>
                                                    <div class="form-group sectioncargarimagen">


                                                        <div class="col-sm-12">
                                                            <div class="file-loading">
                                                                <input
                                                                        id="file-<?php echo e($item->COD_CATEGORIA_DOCUMENTO); ?>"
                                                                        name="<?php echo e($item->COD_CATEGORIA_DOCUMENTO); ?>[]"
                                                                        class="file-es"
                                                                        type="file"
                                                                        multiple data-max-file-count="1"
                                                                        required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php else: ?>
                                                <?php if($item->COD_CATEGORIA_DOCUMENTO == 'DCC0000000000009'): ?>

                                                    <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3 autodetraccion"
                                                         style="margin-top:15px;">
                                                        <div class="form-group sectioncargarimagen">
                                                            <label class="col-sm-12 control-label"
                                                                   style="text-align: left;height: 50px;">
                                                                <div class="tooltipfr">
                                                                    <b><?php echo e($item->NOM_CATEGORIA_DOCUMENTO); ?> <?php echo e($item->TXT_FORMATO); ?></b>
                                                                    <span class="tooltiptext">Solo subir si selecciono que usted pagara la detracion</span>
                                                                </div>
                                                            </label>
                                                            <div class="col-sm-12">
                                                                <div class="file-loading">
                                                                    <input
                                                                            id="file-<?php echo e($item->COD_CATEGORIA_DOCUMENTO); ?>"
                                                                            name="<?php echo e($item->COD_CATEGORIA_DOCUMENTO); ?>[]"
                                                                            class="file-es"
                                                                            type="file"
                                                                            multiple data-max-file-count="1">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php else: ?>
                                                    <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3"
                                                         style="margin-top:15px;">
                                                        <label class="col-sm-12 control-label"
                                                               style="text-align: left;height: 50px;"><b><?php echo e($item->NOM_CATEGORIA_DOCUMENTO); ?>

                                                                (<?php echo e($item->TXT_FORMATO); ?>)</b>
                                                            <?php if($item->COD_CATEGORIA_DOCUMENTO == 'DCC0000000000005'): ?>
                                                                <b>(Descargue el pdf de este enlace <a
                                                                            href="https://e-consultaruc.sunat.gob.pe/cl-ti-itmrconsruc/FrameCriterioBusquedaWeb.jsp"
                                                                            target="_blank">Sunat</a> y subalo para que
                                                                    pueda aprobar</b>)
                                                            <?php else: ?> <?php endif; ?> </label>
                                                        <div class="form-group sectioncargarimagen">

                                                            <div class="col-sm-12">
                                                                <div class="file-loading">
                                                                    <input
                                                                            id="file-<?php echo e($item->COD_CATEGORIA_DOCUMENTO); ?>"
                                                                            name="<?php echo e($item->COD_CATEGORIA_DOCUMENTO); ?>[]"
                                                                            class="file-es"
                                                                            type="file"
                                                                            multiple data-max-file-count="1"
                                                                            required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    <?php 
                                        $otros_documentos_item = $tarchivos->where('COD_CATEGORIA_DOCUMENTO', 'DCC0000000000048')->first();
                                     ?>
                                    <?php if(isset($otros_documentos_item)): ?>
                                        <?php 
                                            $uploaded_pdfs = isset($archivospdf) ? $archivospdf->where('TIPO_ARCHIVO', 'DCC0000000000048') : collect();
                                            $has_uploaded = $uploaded_pdfs->count() > 0;
                                         ?>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top: 25px; border-top: 1px solid #e0e0e0; padding-top: 20px;">
                                            <div class="panel panel-default panel-contrast" style="box-shadow: 0 2px 5px rgba(0,0,0,0.05); border-radius: 6px;">
                                                <div class="panel-heading" style="background: #2b4c7e; color: #fff; font-weight: 600; font-size: 15px; border-top-left-radius: 6px; border-top-right-radius: 6px; display: flex; align-items: center; justify-content: space-between;">
                                                    <span>
                                                        <i class="mdi mdi-folder-multiple" style="margin-right: 8px;"></i>
                                                        <?php echo e($otros_documentos_item->NOM_CATEGORIA_DOCUMENTO); ?> (<?php echo e($otros_documentos_item->TXT_FORMATO); ?> MASIVOS)
                                                    </span>
                                                    <span class="badge" id="badge-pdf-count" data-initial="<?php echo e($uploaded_pdfs->count()); ?>" style="background: #ff5722; color: #fff; font-size: 12px; font-weight: 600;"><?php echo e($uploaded_pdfs->count()); ?> Archivos Cargados</span>
                                                </div>
                                                <div class="panel-body panel-body-contrast" style="padding: 20px;">
                                                    <div class="row">
                                                        <!-- Zona de Carga de Archivos -->
                                                        <div class="<?php echo e($has_uploaded ? 'col-xs-12 col-sm-5 col-md-5 col-lg-5' : 'col-xs-12 col-sm-12 col-md-12 col-lg-12'); ?>">
                                                            <label class="control-label" style="text-align: left; margin-bottom: 10px; font-weight: 700; color: #333;">
                                                                Subir nuevos documentos:
                                                            </label>
                                                            <div class="form-group sectioncargarimagen">
                                                                <div class="col-sm-12" style="padding: 0;">
                                                                    <div class="file-loading">
                                                                        <input
                                                                                id="file-DCC0000000000048"
                                                                                name="DCC0000000000048[]"
                                                                                class="file-es"
                                                                                type="file"
                                                                                multiple
                                                                                data-max-file-count="100"
                                                                                <?php if(!$has_uploaded): ?> required <?php endif; ?>
                                                                                >
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <?php if($has_uploaded): ?>
                                                            <!-- Explorador de Archivos (Derecha) -->
                                                            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7" style="border-left: 1px solid #eee; padding-left: 25px;">
                                                                <label class="control-label" style="text-align: left; margin-bottom: 10px; font-weight: 700; color: #333; display: flex; align-items: center; justify-content: space-between;">
                                                                    <span>Documentos subidos anteriormente:</span>
                                                                    <small class="text-muted" style="font-weight: normal;">Haga clic en previsualizar para ver el PDF al instante</small>
                                                                </label>

                                                                <!-- Buscador de Archivos en Tiempo Real -->
                                                                <div class="form-group" style="margin-bottom: 15px;">
                                                                    <div class="input-group">
                                                                        <span class="input-group-addon" style="background: #2b4c7e; color: #fff; border-color: #2b4c7e; padding: 6px 12px;"><i class="mdi mdi-search" style="font-size: 16px;"></i></span>
                                                                        <input type="text" id="buscar-pdf-input" class="form-control" placeholder="Buscar PDF por nombre..." style="border-color: #2b4c7e; height: 34px;">
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="document-explorer-container" style="max-height: 380px; overflow-y: auto; padding-right: 5px;">
                                                                    <div class="list-group" id="pdf-list-container">
                                                                        <?php $__currentLoopData = $uploaded_pdfs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pdfIndex => $pdf): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                            <?php 
                                                                                $url = route('serve-fileestiba', ['file' => $pdf->NOMBRE_ARCHIVO]);
                                                                             ?>
                                                                            <div class="list-group-item pdf-item" data-nombre="<?php echo e($pdf->NOMBRE_ARCHIVO); ?>" data-url="<?php echo e($url); ?>" data-index="<?php echo e($pdfIndex); ?>" style="border-radius: 4px; margin-bottom: 8px; border: 1px solid #e0e0e0; display: flex; align-items: center; justify-content: space-between; padding: 10px 15px; transition: all 0.2s ease; background: #fff;" onmouseover="this.style.borderColor='#2b4c7e'; this.style.background='#fcfdfe';" onmouseout="this.style.borderColor='#e0e0e0'; this.style.background='#fff';">
                                                                                <div style="display: flex; align-items: center; width: 60%; overflow: hidden;">
                                                                                    <i class="mdi mdi-file-pdf" style="font-size: 28px; color: #d32f2f; margin-right: 12px; flex-shrink: 0;"></i>
                                                                                    <div style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap; text-align: left;">
                                                                                        <span style="font-weight: 600; color: #333; font-size: 13px;" title="<?php echo e($pdf->NOMBRE_ARCHIVO); ?>"><?php echo e($pdf->NOMBRE_ARCHIVO); ?></span>
                                                                                        <br>
                                                                                        <span style="font-size: 11px; color: #777;">Tamaño: <?php echo e(number_format($pdf->SIZE / 1024, 2)); ?> KB</span>
                                                                                    </div>
                                                                                </div>
                                                                                <div style="display: flex; gap: 5px;">
                                                                                    <button type="button" class="btn btn-xs btn-primary btn-preview-pdf" data-url="<?php echo e($url); ?>" data-name="<?php echo e($pdf->NOMBRE_ARCHIVO); ?>" data-index="<?php echo e($pdfIndex); ?>" style="border-radius: 3px; font-weight: 600; display: flex; align-items: center; gap: 4px; padding: 5px 10px; background: #1d3a6d; border-color: #1d3a6d;">
                                                                                        <i class="icon mdi mdi-eye" style="font-size: 14px;"></i> Previsualizar
                                                                                    </button>
                                                                                    <a href="<?php echo e($url); ?>" download class="btn btn-xs btn-default" style="border-radius: 3px; font-weight: 600; display: flex; align-items: center; gap: 4px; padding: 5px 10px; border-color: #ccc; color: #555;">
                                                                                        <i class="icon mdi mdi-download" style="font-size: 14px;"></i> Descargar
                                                                                    </a>
                                                                                </div>
                                                                            </div>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top: 20px;">
                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label labelleft"><b>Usuario Contacto
                                                        :</b></label>
                                                <div class="col-sm-12 abajocaja">
                                                    <input type="text" name="contacto_nombre" id='contacto_nombre'
                                                           class="form-control control input-sm"
                                                           value='<?php echo e($usuario->NOM_TRABAJADOR); ?>' readonly>
                                                </div>
                                            </div>
                                        </div>


                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top: 20px;">
                                        <div class="col-xs-6">

                                        </div>
                                        <div class="col-xs-6">
                                            <p class="text-right">
                                                <input type="hidden" name="idopcion" id='idopcion'
                                                       value='<?php echo e($idopcion); ?>'>
                                                <input type="hidden" name="te" id='te'
                                                       value='<?php echo e($fedocumento->ind_errototal); ?>'>
                                                <input type="hidden" name="valor_igv" id='valor_igv'
                                                       value='<?php echo e((float)$fedocumento->VALOR_IGV_ORIG); ?>'>
                                                <input type="hidden" name="monto_total" id='monto_total'
                                                       value='<?php echo e($fedocumento->TOTAL_VENTA_ORIG); ?>'>
                                                <input type="hidden" name="tipo_documento_id" id='tipo_documento_id'
                                                       value='<?php echo e($fedocumento->ID_TIPO_DOC); ?>'>
                                                <input type="hidden" name="orden_id" id='orden_id' value='<?php echo e($idoc); ?>'>
                                                <input type="hidden" name="contacto_id" id='contacto_id'
                                                       value='<?php echo e($usuario->COD_TRABAJADOR); ?>'>
                                                <button type="submit"
                                                        class="btn btn-space btn-success btn-guardar-xml-comision">
                                                    Guardar
                                                </button>
                                            </p>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        <?php endif; ?>
    </div>
</div>

<!-- Modal de Previsualización de PDF con Navegación Secuencial -->
<div id="previewPdfModal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true" style="display: none; z-index: 9999;">
    <div class="modal-dialog modal-lg" style="width: 90%; max-width: 1200px; margin: 30px auto;">
        <div class="modal-content" style="border-radius: 8px; box-shadow: 0 5px 15px rgba(0,0,0,0.5); overflow: hidden; border: none;">
            <div class="modal-header" style="background: #1d3a6d; color: #fff; padding: 12px 20px; display: flex; align-items: center; justify-content: space-between; border-bottom: none;">
                <div style="display: flex; align-items: center; gap: 15px; width: 50%; overflow: hidden;">
                    <h4 class="modal-title" id="previewPdfTitle" style="margin: 0; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; font-size: 15px;">
                        Previsualización de Documento
                    </h4>
                </div>
                <div style="display: flex; align-items: center; gap: 10px; flex-shrink: 0;">
                    <span id="previewPdfCounter" class="label label-default" style="font-size: 12px; background: rgba(255,255,255,0.2); padding: 5px 10px; border-radius: 3px; font-weight: 600;">
                        Doc 0 de 0
                    </span>
                    <button type="button" class="btn btn-xs btn-warning" id="btnPrevPdf" style="font-weight: 600; border-radius: 3px; background: #ff5722; border-color: #ff5722; padding: 5px 12px; color: #fff;">
                        <i class="mdi mdi-chevron-left" style="font-size: 14px; vertical-align: middle;"></i> Anterior
                    </button>
                    <button type="button" class="btn btn-xs btn-warning" id="btnNextPdf" style="font-weight: 600; border-radius: 3px; background: #ff5722; border-color: #ff5722; padding: 5px 12px; color: #fff;">
                        Siguiente <i class="mdi mdi-chevron-right" style="font-size: 14px; vertical-align: middle;"></i>
                    </button>
                    <a href="#" id="btnDownloadPdf" download class="btn btn-xs btn-success" style="font-weight: 600; border-radius: 3px; padding: 5px 12px; background: #4caf50; border-color: #4caf50; color: #fff; display: inline-flex; align-items: center; gap: 4px;">
                        <i class="mdi mdi-download" style="font-size: 14px;"></i> Descargar
                    </a>
                    <button type="button" class="close" data-dismiss="modal" style="color: #fff; opacity: 0.8; font-size: 24px; line-height: 1; margin: 0; padding: 0; background: none; border: none; cursor: pointer;">&times;</button>
                </div>
            </div>
            <div class="modal-body" style="padding: 0; background: #f4f4f4; height: calc(85vh - 50px);">
                <iframe id="pdfPreviewIframe" src="" style="width: 100%; height: 100%; border: none;"></iframe>
            </div>
        </div>
    </div>
</div>



