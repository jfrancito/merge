import axios from 'axios';
// import $ from 'jquery';

// Hacer jQuery disponible globalmente
// window.$ = window.jQuery = $;
// Configurar Axios
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// /**
//  * Configurar el token CSRF automáticamente
//  */
// let token = document.head.querySelector('meta[name="csrf-token"]');

// if (token) {
//     window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
    
//     // También configurar CSRF para jQuery AJAX
//     $.ajaxSetup({
//         headers: {
//             'X-CSRF-TOKEN': token.content
//         }
//     });
// } else {
//     console.error('CSRF token not found');
// }

// import axios from 'axios';
// window.axios = axios;

// window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
// /**
//  * Configurar el token CSRF automáticamente en todas las peticiones
//  */
// let token = document.head.querySelector('meta[name="csrf-token"]');

// if (token) {
//     window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
// } else {
//     console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
// }