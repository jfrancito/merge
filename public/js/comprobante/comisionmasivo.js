$(document).ready(function() {
    // Inicializar elementos de formulario si existen
    if (typeof App !== 'undefined') {
        App.init();
        App.formElements();
    }
    
    // Inicializar Select2 para el documento
    if ($.fn.select2) {
        $('.select2').select2();
    }

    // Inicializar Bootstrap FileInput para PDFs masivos
    if ($.fn.fileinput) {
        $('#inputpdf').fileinput({
            language: "es",
            allowedFileExtensions: ["pdf"],
            showPreview: true,
            showUpload: false,
            browseClass: "btn btn-primary",
            elErrorContainer: "#errorBlock",
            maxFileSize: 10240, // 10MB
            overwriteInitial: false,
            dropZoneEnabled: true
        });
    }
});
