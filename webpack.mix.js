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
// Main Website
mix.js('resources/assets/js/home-page/app.js', 'public/js/home-page');
mix.sass('resources/assets/sass/home-page/app.scss', 'public/css/home-page');

// Bulma
mix.js('resources/assets/js/bulma/app.js', 'public/js/bulma');
mix.sass('resources/assets/sass/bulma/app.scss', 'public/css/bulma');

// Web Apps
// ELearning Template
mix.js('resources/assets/js/templates/web-apps/elearning/app.js', 'public/js/templates/web-apps/elearning');

// Websites
// Bizlight Template
mix.js('resources/assets/js/templates/websites/bizlight/app.js', 'public/js/templates/websites/bizlight');
mix.sass('resources/assets/sass/templates/websites/bizlight/app.scss', 'public/css/templates/websites/bizlight');

// Portfolios
// Template 1
mix.js('resources/assets/js/templates/portfolios/template1/site/app.js', 'public/js/templates/portfolios/template1/site');
mix.js('resources/assets/js/templates/portfolios/template1/dashboard/app.js', 'public/js/templates/portfolios/template1/dashboard');
mix.sass('resources/assets/sass/templates/portfolios/template1/app.scss', 'public/css/templates/portfolios/template1');

// Blogs
// Template 1
mix.js('resources/assets/js/templates/blogs/template1/site/app.js', 'public/js/templates/blogs/template1/site');
mix.js('resources/assets/js/templates/blogs/template1/dashboard/app.js', 'public/js/templates/blogs/template1/dashboard');
mix.sass('resources/assets/sass/templates/blogs/template1/app.scss', 'public/css/templates/blogs/template1');
