import './bootstrap';
import * as bootstrap from 'bootstrap';

// CRÍTICO: Exponer Bootstrap GLOBALMENTE antes de importar custom.js
window.bootstrap = bootstrap;

// import $ from 'jquery';
// window.$ = window.jQuery = $;

// // Ahora sí importar los vendor files
// import './vendor/apexcharts.js';
// import './vendor/echarts.js';
// import './vendor/custom.js';

document.addEventListener('DOMContentLoaded', function() {
    console.log('App.js cargado');
    console.log('Bootstrap disponible:', typeof window.bootstrap !== 'undefined');
    console.log('jQuery version:', $.fn.jquery);
});

// import './bootstrap';
// import * as bootstrap from 'bootstrap';
// window.bootstrap = bootstrap; // ← Esto debe estar ANTES de custom.js

// import $ from 'jquery';
// window.$ = window.jQuery = $;

// // Importar vendor DESPUÉS de exponer bootstrap y jQuery
// import './vendor/apexcharts.js';
// import './vendor/echarts.js';
// import './vendor/custom.js'; // ← Ahora sí tendrá acceso a window.bootstrap

// document.addEventListener('DOMContentLoaded', function() {
//     console.log('App.js cargado');
//     console.log('Bootstrap version:', typeof bootstrap !== 'undefined' ? 'cargado' : 'no cargado');
//     console.log('jQuery version:', $.fn.jquery);
// });

// import './bootstrap';

// import * as bootstrap from 'bootstrap';
// window.bootstrap = bootstrap;

// import $ from 'jquery';
// window.$ = window.jQuery = $;

// // import '../../public/assets/js/custom/custom.js';
// import './vendor/apexcharts.js';
// import './vendor/echarts.js';
// import './vendor/custom.js';

// document.addEventListener('DOMContentLoaded', function() {
//     console.log('App.js cargado');
//     console.log('Bootstrap version:', typeof bootstrap !== 'undefined' ? 'cargado' : 'no cargado');
//     console.log('jQuery version:', $.fn.jquery);
// });
// import './bootstrap';

// import * as bootstrap from 'bootstrap'; // <- ESTA ES LA CORRECTA
// window.bootstrap = bootstrap;           // <- Esto crea la variable global

// import $ from 'jquery';
// window.$ = window.jQuery = $;
// // import '../../public/assets/js/custom/custom.js';

// document.addEventListener('DOMContentLoaded', function() {
//     console.log('App.js cargado');
//     console.log('Bootstrap version:', typeof bootstrap !== 'undefined' ? 'cargado' : 'no cargado');
//     console.log('jQuery version:', $.fn.jquery);
// });


// import './bootstrap';
// import $ from 'jquery';
// window.$ = window.jQuery = $;

// import 'bootstrap/dist/css/bootstrap.min.css';
// import * as bootstrap from 'bootstrap';
// window.bootstrap = bootstrap;

// import '../css/app.css';


// import './bootstrap';
// import 'bootstrap'; // Esto importa el JavaScript de Bootstrap
// import $ from 'jquery';

// window.$ = window.jQuery = $;

// // Inicializar dropdowns manualmente si es necesario
// document.addEventListener('DOMContentLoaded', function() {
//     console.log('App.js cargado');
//     console.log('Bootstrap version:', typeof bootstrap !== 'undefined' ? 'cargado' : 'no cargado');
//     console.log('jQuery version:', $.fn.jquery);
// });

// import './bootstrap';
// import 'bootstrap';

// // jQuery ya está disponible globalmente como $ y jQuery
// console.log('jQuery version:', $.fn.jquery);

// // Código cuando el DOM esté listo
// $(document).ready(function() {
//     console.log('jQuery está funcionando!');
    
//     // Tu código jQuery aquí
// });

// import './bootstrap';
// import 'bootstrap';

// // Aquí puedes agregar tu código JavaScript adicional
// console.log('App.js cargado correctamente');

// // Ejemplo de uso de Axios
// document.addEventListener('DOMContentLoaded', function() {
//     // Tu código aquí
// });


// // resources/js/app.js

// // Configuración de Axios (importa tu archivo bootstrap.js)
// import './bootstrap';

// // jQuery
// import $ from 'jquery';
// window.$ = window.jQuery = $;

// // Bootstrap JavaScript
// import * as bootstrap from 'bootstrap';
// window.bootstrap = bootstrap;

// // Estilos
// import 'bootstrap/dist/css/bootstrap.min.css';
// import '../css/app.css';

// // Inicializar componentes de Bootstrap automáticamente
// document.addEventListener('DOMContentLoaded', function() {
//     // Inicializar todos los dropdowns
//     const dropdownElementList = document.querySelectorAll('[data-bs-toggle="dropdown"]');
//     const dropdownList = [...dropdownElementList].map(dropdownToggleEl => 
//         new bootstrap.Dropdown(dropdownToggleEl)
//     );

//     // Inicializar todos los tooltips si los usas
//     const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
//     const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => 
//         new bootstrap.Tooltip(tooltipTriggerEl)
//     );
// });