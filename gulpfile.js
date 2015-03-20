var elixir = require('laravel-elixir');

require('laravel-elixir-wiredep');
/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */
var bowerDir = './public/vendor/';

var lessPaths = [
    bowerDir + 'bootstrap/less/'
]

elixir(function(mix) {
    mix.less("main.less", "public/css/", {paths: lessPaths})
        .wiredep({src: "master.blade.php"}, {exclude: 'vendor/bootstrap/dist/css/bootstrap.css'});
});
