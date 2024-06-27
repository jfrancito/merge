function toggleContent() {
  var longText = document.getElementById('longText');
  var button = document.getElementById('toggleButton');
  if (longText.classList.contains('collapsed')) {
    longText.classList.remove('collapsed');
    button.innerHTML = "- Ver Menos";
  } else {
    longText.classList.add('collapsed');
    button.innerHTML = "+ Ver Más";
  }
}

// Inicialmente colapsar el contenido adicional
document.addEventListener("DOMContentLoaded", function() {
  document.getElementById('longText').classList.add('collapsed');
});



$(document).ready(function(){

    var carpeta = $("#carpeta").val();
    $(".registrocomprobante").on('click','.btn-guardar-xml', function(e) {

        event.preventDefault();
        var _token                  =   $('#token').val();
        var te                      =   $('#te').val();
        if(te =='0'){ alerterrorajax("Hay errores en la validacion del XML."); return false;}

        $.confirm({
            title: '¿Confirmar la validación?',
            content: 'Merge de Comprobante',
            buttons: {
                confirmar: function () {
                    //abrircargando();
                    $( "#formguardardatos" ).submit();
                },
                cancelar: function () {
                    $.alert('Se cancelo la validación');
                }
            }
        });


    });

    $(".registrocomprobante").on('click','#cargardatosliq', function(e) {
        abrircargando();
    });



});




