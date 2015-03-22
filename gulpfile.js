var elixir = require('laravel-elixir');
var gulp = require("gulp");

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
var bowerDir = "public/vendor/";

var lessPaths = [
    bowerDir + "bootstrap/less/"
]

var templatePaths = [
    "resources/assets/js/app/components/*/*.html",
];

elixir.extend("templates", function(src, base, dest) {
    gulp.task("templates", function () {
        // the base option sets the relative root for the set of files,
        // preserving the folder structure
        gulp.src(src, {base: base})
            .pipe(gulp.dest(dest));
    });
    // Watch each glob in src
    for (idx in src){
        var glob = src[idx];
        this.registerWatcher("templates", glob);
    }
    return this.queueTask("templates");
});

elixir(function(mix) {
    // Complile LESS into CSS
    mix.less("main.less", "public/css/", {paths: lessPaths});
    // Inject dependencies into layout (except bootstrap css, since that is compiled into main css)
    mix.wiredep({src: "master.blade.php"}, {exclude: "vendor/bootstrap/dist/css/bootstrap.css"});
    // Combine app js into one file
    mix.scriptsIn("resources/assets/js/", "public/js/main.js");
    // Copy angular templates to public folder
    mix.templates(templatePaths, "resources/assets/js/app/components/", "public");
});
