const mix = require('laravel-mix');
require('dotenv').config({
    path: __dirname + '/../../.env'
});

require('laravel-mix-polyfill');

mix.autoload({
    jquery: ['$', 'window.jQuery', 'jQuery'], // more than one
    moment: 'moment' // only one
});

mix.js('Resources/js/app.js', 'Resources/views/dist/js')
    .sass('Resources/sass/app.scss', 'Resources/views/dist/css');


mix.extract(['jquery']);


mix.polyfill({
    enabled: true,
    useBuiltIns: "usage",
    //targets: { "firefox": "50", "ie": 11 }
    targets: "firefox 50, IE 11"
});


var $prefix = '../..';
var $suffix = '/themes/Zero'
var $resource_root = $prefix + $suffix;
var $public_path = $prefix + process.env.MIX_PUBLIC_FOLDER  + $suffix;

console.log('public_path :' + $public_path);
console.log('dirname :' + __dirname);
$res = mix.copyDirectory(__dirname + '/Resources/views/dist', $public_path + '/dist');


/*
(node:640) UnhandledPromiseRejectionWarning: Error: ENOENT: no such file or directory, open '/Resources/views/dist/css/app.css'
if (mix.inProduction()) {
    mix.version();
    mix.sourceMaps();
}
*/