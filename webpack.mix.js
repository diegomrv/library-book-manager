const { mix } = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css')
   .combine([
   		'public/css/app.css', 
   		'node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css', 
   		'node_modules/select2/dist/css/select2.min.css'
   	], 'public/css/app.css');
