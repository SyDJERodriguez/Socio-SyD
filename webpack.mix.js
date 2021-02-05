const mix = require('laravel-mix');

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



/*mix.js('resources/assets/js/app.js', 'public/js');
mix.sass('resources/assets/sass/sb-admin-2.scss', 'public/css');
/*mix.copy('resources/assets/vendor','public/vendor');
mix.js([
    'resources/assets/js/sb-admin-2.js',
],'public/js');
mix.copy([
    'resources/assets/js/demo/*',
],'public/js/demo/');
*/
mix.copy('resources/assets/img','public/img');


//Mix collectors pages
mix.js('resources/assets/collectors/js/app.js', 'public/collectors/js')
    .sass('resources/assets/collectors/sass/app.scss', 'public/collectors/css')
    .sass('resources/assets/collectors/sass/stage_two.scss', 'public/collectors/css');


mix.copy('resources/assets/collectors/img/','public/collectors/img');
mix.copy('resources/assets/collectors/fonts/','public/collectors/fonts');

/**Mix Landing pages **/
/*mix.js('resources/assets/landings/js/app.js', 'public/landings/js')
    .sass('resources/assets/landings/sass/main.scss', 'public/landings/css');


mix.copy('resources/assets/landings/images/','public/landings/images');*/
//Mix administrator
/*mix.js('resources/assets/administrators/js/app.js', 'public/administrators/js')
    .sass('resources/assets/administrators/sass/app.scss', 'public/administrators/css');

//mix.copy('resources/assets/administrators/img/','public/administrators/img');*/
