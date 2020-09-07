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

mix.autoload({
    jquery: ['$', 'window.jQuery', 'jQuery'],
    tether: ['window.Tether', 'Tether'],
    'tether-shepherd': ['Shepherd'],
    'popper.js/dist/popper.js': ['Popper']
})
    .js('resources/js/app.js', 'dist/js')
    .sass('resources/sass/app.scss', 'dist/css')
    .options({
        postCss: [
            require('precss')()
        ]
    });
