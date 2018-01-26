let mix = require('laravel-mix');

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

mix.js('resources/assets/js/home-page/app.js', 'public/js/home-page')
    .sass('resources/assets/sass/home-page/app.scss', 'public/css/home-page')

    .js('resources/assets/js/bulma/app.js', 'public/js/bulma')
    .sass('resources/assets/sass/bulma/app.scss', 'public/css/bulma')

    .js('resources/assets/js/templates/web-apps/elearning/app.js', 'public/js/templates/web-apps/elearning')

    .js('resources/assets/js/templates/websites/bizlight/app.js', 'public/js/templates/websites/bizlight')
    .sass('resources/assets/sass/templates/websites/bizlight/app.scss', 'public/css/templates/websites/bizlight')
   
    .js('resources/assets/js/templates/portfolios/theme1/app.js', 'public/js/templates/portfolios/theme1')
    .sass('resources/assets/sass/templates/portfolios/theme1/app.scss', 'public/css/templates/portfolios/theme1');
