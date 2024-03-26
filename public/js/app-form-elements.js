


var App = (function () {
  'use strict';

  App.formElements = function( ){

    //Js Code
    $(".datetimepicker").datetimepicker({
    	autoclose: true,
      pickerPosition: "bottom-left",
    	componentIcon: '.mdi.mdi-calendar',
    	navIcons:{
    		rightIcon: 'mdi mdi-chevron-right',
    		leftIcon: 'mdi mdi-chevron-left'
    	}

    });
    
    //Select2
    $(".select2").select2({
      width: '100%'
    });
    
    //Select2 tags
    $(".tags").select2({tags: true, width: '100%'});

    //Bootstrap Slider
    $('.bslider').bootstrapSlider();

    window.Parsley.addValidator('fechamayor', {
      validateString: function(value, requirement) {
        var $fechamenor = $('#'+requirement).val();
        return validate_fechaMayorQue($fechamenor,value);
      },
      messages: {
        es: 'La fecha debe ser mayor a la %s.'
      }
    });


    
    
  };

  return App;
})(App || {});
