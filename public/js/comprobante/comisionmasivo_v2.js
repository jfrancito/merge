$(document).ready(function() {
    console.log("comisionmasivo_v2.js cargado correctamente");

    // Inicializar elementos de formulario si existen
    if (typeof App !== 'undefined') {
        App.init();
        App.formElements();
    }
    
    // Inicializar Select2 para el documento
    if ($.fn.select2) {
        $('.select2').select2();
    }

    // Archivos seleccionados en caché para previsualización
    var selectedPdfFiles = [];
    var parsedPdfsData = [];

    // Cargar la librería pdf.js dinámicamente si no está presente
    function cargarPdfJs(callback) {
        if (typeof pdfjsLib !== 'undefined') {
            callback();
            return;
        }
        var script = document.createElement('script');
        script.src = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js';
        script.onload = function() {
            pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.worker.min.js';
            callback();
        };
        script.onerror = function() {
            console.error("No se pudo cargar la librería PDF.js desde CDN.");
            callback(true);
        };
        document.head.appendChild(script);
    }

    // Inicializar Bootstrap FileInput para PDFs masivos sin previsualización integrada
    if ($.fn.fileinput) {
        $('#inputpdf').fileinput({
            language: "es",
            allowedFileExtensions: ["pdf"],
            showPreview: false,
            showUpload: false,
            browseClass: "btn btn-primary",
            elErrorContainer: "#errorBlock",
            maxFileSize: 10240, // 10MB
            overwriteInitial: false
        });
    }

    // Escuchar el cambio en la selección del input de PDF
    $(document).on('change fileselect', '#inputpdf', function(e) {
        // Resetear el panel detalle y deshabilitar el botón de guardar
        $('#panel-detalle-pdfs').hide();
        $('#tabla-detalle-pdfs-body').empty();
        $('#btn-guardar-comision-masivo').attr('disabled', 'disabled');
        selectedPdfFiles = [];
        parsedPdfsData = [];

        if (this.files && this.files.length > 0) {
            selectedPdfFiles = Array.from(this.files);
        }
    });

    // Escuchar el clic en Subir PDFs para gatillar el análisis y mostrar el panel informativo
    $(document).on('click', '#btncargarpdfmasivo', function(e) {
        e.preventDefault();

        if (selectedPdfFiles.length === 0) {
            alerterrorajax("Debe seleccionar al menos un archivo PDF.");
            return false;
        }

        var container = $('#panel-detalle-pdfs');
        var tableBody = $('#tabla-detalle-pdfs-body');
        var valBox = $('#validacion-totales-pdf');
        var valMsg = $('#resultado-validacion-msg');

        tableBody.empty();
        container.hide();
        parsedPdfsData = [];

        // Mostrar loading spinner global
        abrircargando("Analizando comprobantes PDFs...");

        // Cargar PDF.js y procesar
        cargarPdfJs(function(errorCarga) {
            if (errorCarga) {
                cerrarcargando();
                alerterrorajax("No se pudo cargar la librería PDF.js para analizar los comprobantes.");
                return;
            }

            var promises = selectedPdfFiles.map(function(file) {
                return obtenerTotalDePdf(file);
            });

            Promise.all(promises).then(function(resultados) {
                var totalPdfSum = 0;
                parsedPdfsData = [];
                var docId = $('#documento_id').val();
                var noCorresponden = [];

                // Resetear badges de PDF en XML mode
                if (docId !== 'DCC0000000000048') {
                    $('.pdf-asoc-badge').removeClass('label-success').addClass('label-danger').text('No cargado');
                }

                resultados.forEach(function(res, index) {
                    totalPdfSum += res.total;
                    
                    // Guardar en la caché de metadatos
                    parsedPdfsData.push({
                        filename: res.name,
                        serie: res.serie,
                        numero: res.numero,
                        subtotal: res.subtotal,
                        igv: res.igv,
                        total: res.total,
                        interes: res.interes,
                        comisiones: res.comisiones
                    });

                    // Si es modo XML, emparejar con el badge correspondiente
                    if (docId !== 'DCC0000000000048') {
                        var badge = $('.pdf-asoc-badge[data-serie="' + res.serie + '"][data-numero="' + parseInt(res.numero) + '"]');
                        if (badge.length > 0) {
                            badge.removeClass('label-danger').addClass('label-success').text(res.name);
                        } else {
                            noCorresponden.push(res.name + " (" + res.serie + "-" + res.numero + ")");
                        }
                    }

                    var totalStr = res.total > 0 ? 'S/ ' + res.total.toFixed(2) : '0.00';
                    
                    var itemHtml = `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${res.serie}</td>
                            <td>${res.numero}</td>
                            <td class="negrita">${totalStr}</td>
                            <td style="text-align: center;">
                                <button type="button" class="btn btn-default btn-xs ver-pdf-temp" data-index="${index}" style="border: none; background: transparent; padding: 0 4px;" title="Ver PDF">
                                    <span class="mdi mdi-eye" style="font-size: 16px; color: #1d3a6d;"></span>
                                </button>
                            </td>
                        </tr>
                    `;
                    tableBody.append(itemHtml);
                });

                // Mostrar el panel de detalles sólo si es otros documentos
                if (docId === 'DCC0000000000048') {
                    container.show();
                    validarTotales(totalPdfSum);
                } else {
                    container.hide();
                    if (noCorresponden.length > 0) {
                        alerterrorajax("<b>Advertencia!</b> Los siguientes PDFs no corresponden a ningún XML cargado:<br><br>" + noCorresponden.join("<br>"));
                    }
                }

                // Habilitar el botón Guardar Todo
                $('#btn-guardar-comision-masivo').removeAttr('disabled');

                cerrarcargando();

            }).catch(function(err) {
                cerrarcargando();
                console.error("Error al procesar PDFs:", err);
                alerterrorajax("Error al procesar los archivos PDF.");
            });
        });
    });

    // Función promesa que extrae el texto del PDF y parsea los campos principales
    function obtenerTotalDePdf(file) {
        return new Promise(function(resolve, reject) {
            var reader = new FileReader();
            reader.onload = function() {
                var typedarray = new Uint8Array(this.result);
                pdfjsLib.getDocument(typedarray).promise.then(function(pdf) {
                    pdf.getPage(1).then(function(page) {
                        page.getTextContent().then(function(textContent) {
                            var text = textContent.items.map(function(item) {
                                return item.str;
                            }).join(' ');
                            
                            console.log("Texto extraido de " + file.name + ":", text);
                            
                            // 1. Extraer Serie y Número
                            var serie = 'SS00';
                            var numero = '0000000000';
                            var matchSN = text.match(/([FfBbEe][A-Za-z0-9]{3})-([0-9]+)/);
                            if (matchSN) {
                                serie = matchSN[1].toUpperCase();
                                numero = matchSN[2];
                            }
                            // Fallback a extraer del nombre de archivo si no coincide
                            if (serie === 'SS00' || numero === '0000000000') {
                                var matchFN = file.name.match(/([FfBbEe][A-Za-z0-9]{3})-?([0-9]+)/i);
                                if (matchFN) {
                                    serie = matchFN[1].toUpperCase();
                                    numero = matchFN[2];
                                }
                            }

                            // 2. Extraer IGV
                            var igv = 0;
                            var matchIgv = text.match(/I\.?G\.?V\.?\s*([\d,]+\.\d{2})/i);
                            if (matchIgv) {
                                igv = parseFloat(matchIgv[1].replace(/,/g, ''));
                            }

                            // 3. Extraer Total
                            var regexesTotal = [
                                /Importe\s+Total\s*([\d,]+\.\d{2})/i,
                                /Importe\s+Total\s*:\s*([\d,]+\.\d{2})/i,
                                /Total\s*:\s*([\d,]+\.\d{2})/i,
                                /Total\s+Venta\s*([\d,]+\.\d{2})/i,
                                /PRECIO\s+VENTA\s+TOTAL\s*([\d,]+\.\d{2})/i,
                                /Total\s*([\d,]+\.\d{2})/i
                            ];

                            var total = 0;
                            for (var i = 0; i < regexesTotal.length; i++) {
                                var match = text.match(regexesTotal[i]);
                                if (match) {
                                    total = parseFloat(match[1].replace(/,/g, ''));
                                    break;
                                }
                            }

                            // Normalizar espacios para evitar inconsistencias
                            var cleanText = text.replace(/\s+/g, ' ');

                            // 4. Extraer Subtotal
                            var subtotal = 0;
                            var matchSub = cleanText.match(/Sub\s*Total\s*([\d,]+\.\d{2})/i);
                            if (matchSub) {
                                subtotal = parseFloat(matchSub[1].replace(/,/g, ''));
                            } else {
                                subtotal = total - igv;
                            }

                            var interes = { subtotal: 0, igv: 0, total: 0 };
                            var comisiones = { subtotal: 0, igv: 0, total: 0 };

                            // 5. Intentar matching de columnas continuas (Layout Columna por Columna)
                            // "Interés Adelantado Comisiones 1,154.36 0.00 1,154.36 3.50 0.00 3.50"
                            var matchCol = cleanText.match(/Inter[eé]s\s+Adelantado\s+Comisiones\s+([\d,]+\.\d{2})\s+([\d,]+\.\d{2})\s+([\d,]+\.\d{2})\s+([\d,]+\.\d{2})\s+([\d,]+\.\d{2})\s+([\d,]+\.\d{2})/i);
                            if (matchCol) {
                                interes.subtotal = parseFloat(matchCol[1].replace(/,/g, ''));
                                interes.igv = parseFloat(matchCol[2].replace(/,/g, ''));
                                interes.total = parseFloat(matchCol[3].replace(/,/g, ''));
                                
                                comisiones.subtotal = parseFloat(matchCol[4].replace(/,/g, ''));
                                comisiones.igv = parseFloat(matchCol[5].replace(/,/g, ''));
                                comisiones.total = parseFloat(matchCol[6].replace(/,/g, ''));
                            } else {
                                // 6. Intentar matching de filas individuales (Layout Fila por Fila)
                                var matchInteres = cleanText.match(/Inter[eé]s\s+Adelantado\s+([\d,]+\.\d{2})\s+([\d,]+\.\d{2})\s+([\d,]+\.\d{2})/i);
                                if (matchInteres) {
                                    interes.subtotal = parseFloat(matchInteres[1].replace(/,/g, ''));
                                    interes.igv = parseFloat(matchInteres[2].replace(/,/g, ''));
                                    interes.total = parseFloat(matchInteres[3].replace(/,/g, ''));
                                } else {
                                    var matchInteresSimple = cleanText.match(/Inter[eé]s\s+Adelantado\s+([\d,]+\.\d{2})/i);
                                    if (matchInteresSimple) {
                                        interes.subtotal = parseFloat(matchInteresSimple[1].replace(/,/g, ''));
                                        interes.total = interes.subtotal;
                                    }
                                }

                                var matchComisiones = cleanText.match(/Comisiones\s+([\d,]+\.\d{2})\s+([\d,]+\.\d{2})\s+([\d,]+\.\d{2})/i);
                                if (matchComisiones) {
                                    comisiones.subtotal = parseFloat(matchComisiones[1].replace(/,/g, ''));
                                    comisiones.igv = parseFloat(matchComisiones[2].replace(/,/g, ''));
                                    comisiones.total = parseFloat(matchComisiones[3].replace(/,/g, ''));
                                } else {
                                    var matchComisionesSimple = cleanText.match(/Comisiones\s+([\d,]+\.\d{2})/i);
                                    if (matchComisionesSimple) {
                                        comisiones.subtotal = parseFloat(matchComisionesSimple[1].replace(/,/g, ''));
                                        comisiones.total = comisiones.subtotal;
                                    }
                                }
                            }

                            // 7. Fallback matemático por si falló la extracción de los montos específicos del PDF
                            if (interes.total === 0 && comisiones.total === 0 && total > 3.50) {
                                comisiones.subtotal = 3.50;
                                comisiones.igv = 0.00;
                                comisiones.total = 3.50;

                                interes.subtotal = total - 3.50;
                                interes.igv = 0.00;
                                interes.total = total - 3.50;
                            }

                            resolve({
                                name: file.name,
                                serie: serie,
                                numero: numero,
                                subtotal: subtotal,
                                igv: igv,
                                total: total,
                                interes: interes,
                                comisiones: comisiones
                            });
                        }).catch(function() { resolve({ name: file.name, serie: 'SS00', numero: '0000000000', subtotal: 0, igv: 0, total: 0, interes: { subtotal: 0, igv: 0, total: 0 }, comisiones: { subtotal: 0, igv: 0, total: 0 } }); });
                    }).catch(function() { resolve({ name: file.name, serie: 'SS00', numero: '0000000000', subtotal: 0, igv: 0, total: 0, interes: { subtotal: 0, igv: 0, total: 0 }, comisiones: { subtotal: 0, igv: 0, total: 0 } }); });
                }).catch(function() { resolve({ name: file.name, serie: 'SS00', numero: '0000000000', subtotal: 0, igv: 0, total: 0, interes: { subtotal: 0, igv: 0, total: 0 }, comisiones: { subtotal: 0, igv: 0, total: 0 } }); });
            };
            reader.readAsArrayBuffer(file);
        });
    }

    // Compara la sumatoria de PDFs con la sumatoria de documentos asociados
    function validarTotales(totalPdfSum) {
        var totalAsociados = parseFloat($('#total_asociado_oc').val()) || 0;
        var valBox = $('#validacion-totales-pdf');
        var valAsoc = $('#total-doc-asociados-val');
        var valPdf = $('#total-pdfs-val');
        var valMsg = $('#resultado-validacion-msg');

        valAsoc.text('S/ ' + totalAsociados.toFixed(2));
        valPdf.text('S/ ' + totalPdfSum.toFixed(2));

        var diferencia = Math.abs(totalAsociados - totalPdfSum);
        
        if (diferencia <= 0.02) {
            valBox.css({
                'background': '#e8f5e9',
                'border': '1px solid #c8e6c9',
                'color': '#2e7d32'
            });
            valMsg.html('<i class="mdi mdi-check-circle" style="font-size: 14px;"></i> LOS TOTALES COINCIDEN');
        } else {
            valBox.css({
                'background': '#ffebee',
                'border': '1px solid #ffcdd2',
                'color': '#c62828'
            });
            valMsg.html('<i class="mdi mdi-close-circle" style="font-size: 14px;"></i> LOS TOTALES NO COINCIDEN');
        }
    }

    // Escuchar el botón Guardar Todo
    $(document).on('click', '#btn-guardar-comision-masivo', function(e) {
        e.preventDefault();

        // Validar selección de documentos
        var jsondocumenos_val = $('#jsondocumenos').val();
        if (!jsondocumenos_val || jsondocumenos_val === '[]') {
            alerterrorajax("No hay operaciones seleccionadas.");
            return false;
        }

        var docId = $('#documento_id').val();
        var msgConfirm = '';
        if (docId === 'DCC0000000000048') {
            // Validar que se hayan cargado PDFs (solo en modo otros documentos)
            if (selectedPdfFiles.length === 0 || parsedPdfsData.length === 0) {
                alerterrorajax("Debe cargar al menos un archivo PDF.");
                return false;
            }
            // Configurar mensaje y mostrar confirmación
            var totalComprobantes = selectedPdfFiles.length;
            msgConfirm = 'Se procesarán y guardarán <span class="negrita">' + totalComprobantes + '</span> facturas y se asociarán con las operaciones caja de comisiones.';
        } else {
            // Modo XML
            msgConfirm = 'Se procesará y guardará el comprobante XML y se asociará con las operaciones caja de comisiones.';
        }

        $('#modal-confirmacion-mensaje').html(msgConfirm);
        $('#modal-confirmacion-premium').modal('show');
    });

    // Acción para el botón de confirmar en el modal de confirmación premium
    $(document).on('click', '#btn-modal-confirmacion-aceptar', function() {
        $('#modal-confirmacion-premium').modal('hide');
        ejecutarGuardadoMasivo();
    });

    // Acción para el botón de cancelar en el modal de confirmación premium
    $(document).on('click', '#btn-modal-confirmacion-cancelar', function() {
        $('#modal-confirmacion-premium').modal('hide');
    });

    function ejecutarGuardadoMasivo() {
        var jsondocumenos_val = $('#jsondocumenos').val();
        var docId = $('#documento_id').val();
        abrircargando("Guardando comprobantes...");
        
        var formData = new FormData();
        formData.append('_token', $('#token').val());
        formData.append('jsondocumenos', jsondocumenos_val);
        formData.append('documento_id', docId);

        if (docId === 'DCC0000000000048') {
            formData.append('pdfs_info', JSON.stringify(parsedPdfsData));
        }
        
        if (selectedPdfFiles.length > 0) {
            selectedPdfFiles.forEach(function(file) {
                formData.append('inputpdf[]', file);
            });
        }

        var urlGuardar = $('#carpeta').val() + '/guardar-comision-masivo-documentos/' + $('#idopcion').val();

        $.ajax({
            url: urlGuardar,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                cerrarcargando();
                if (response.success) {
                    $('#modal-exito-mensaje').html(response.message);
                    $('#modal-exito-premium').modal('show');
                } else {
                    alerterrorajax(response.message);
                }
            },
            error: function(xhr, status, error) {
                cerrarcargando();
                alerterrorajax("Ocurrió un error al procesar el guardado masivo en el servidor.");
            }
        });
    }

    // Escuchar cuando se limpia el input
    $(document).on('filecleared', '#inputpdf', function() {
        $('#panel-detalle-pdfs').hide();
        $('#tabla-detalle-pdfs-body').empty();
        $('#btn-guardar-comision-masivo').attr('disabled', 'disabled');
        selectedPdfFiles = [];
        parsedPdfsData = [];
    });

    // Evento para ver el PDF en el modal
    $(document).on('click', '.ver-pdf-temp', function(e) {
        e.preventDefault();
        var index = $(this).data('index');
        var file = selectedPdfFiles[index];

        if (file) {
            var fileUrl = URL.createObjectURL(file);
            $('#pdfPreviewIframe').attr('src', fileUrl);
            $('#previewPdfTitle').text(file.name);
            $('#previewPdfCounter').text('Archivo Local');
            
            // Ocultar botones de navegación secuencial
            $('#btnPrevPdf, #btnNextPdf').hide();
            
            // Configurar el botón de descargar
            $('#btnDownloadPdf').attr('href', fileUrl).attr('download', file.name).show();

            $('#previewPdfModal').modal('show');
        }
    });

    // Al cerrar el modal, liberar el ObjectURL para optimizar memoria
    $('#previewPdfModal').on('hide.bs.modal', function() {
        var currentSrc = $('#pdfPreviewIframe').attr('src');
        if (currentSrc && currentSrc.indexOf('blob:') === 0) {
            URL.revokeObjectURL(currentSrc);
        }
        $('#pdfPreviewIframe').attr('src', '');
    });

    // Acción para el botón de aceptar en el modal de éxito premium
    $(document).on('click', '#btn-modal-exito-aceptar', function() {
        window.location.href = $('#carpeta').val() + '/gestion-de-integracion-comisiones/' + $('#idopcion').val();
    });

    // Validación al subir el XML
    $(document).on('submit', '#formcargardatos', function(e) {
        var docId = $('#documento_id').val();
        var xmlInput = $('#inputxml')[0];
        
        // Si el tipo de documento es diferente a "OTROS DOCUMENTOS" (DCC0000000000048)
        if (docId !== 'DCC0000000000048') {
            // Verificar si el archivo XML fue seleccionado
            if (!xmlInput.files || xmlInput.files.length === 0) {
                e.preventDefault();
                $('#modal-advertencia-mensaje').html("Advertencia! Seleccione Archivo XML a Importar.");
                $('#modal-advertencia-premium').modal('show');
                return false;
            }
        }
    });

    // Acción para el botón de aceptar en el modal de advertencia premium
    $(document).on('click', '#btn-modal-advertencia-aceptar', function() {
        $('#modal-advertencia-premium').modal('hide');
    });

    // Cambiar paneles dinámicamente según el tipo de documento seleccionado
    $(document).on('change', '#documento_id', function() {
        var docId = $(this).val();
        
        // Ocultar paneles de detalles y comparaciones
        $('#panel-detalle-pdfs').hide();
        $('#tabla-detalle-pdfs-body').empty();
        $('#panel-xml-detalle-container').hide();
        
        // Deshabilitar botón Guardar Todo
        $('#btn-guardar-comision-masivo').attr('disabled', 'disabled');
        
        if (docId === 'DCC0000000000048') {
            // Mover el panel al contenedor central (col-pdf-mid) y quitar margen superior
            $('#panel-pdf-masivo-container').css('margin-top', '0px').appendTo('#col-pdf-mid');
            $('#panel-pdf-masivo-container').show();
            $('#panel-api-sunat-container').hide();
        } else {
            // Mover el panel al contenedor izquierdo (col-pdf-left) y agregar margen superior
            $('#panel-pdf-masivo-container').css('margin-top', '15px').appendTo('#col-pdf-left');
            $('#panel-pdf-masivo-container').show();
            $('#panel-api-sunat-container').show();
        }
    });
});
