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

mix.js('resources/js/app.js', 'public/js')
    .vue()
    .sass('resources/sass/app.scss', 'public/css');
    // .browserSync({
    //     proxy: 'http://localhost:8000/',
    //     open: false,
    //     files: [
    //         'resources/views/**/*.php',
    //         'resources/js/**/*.vue',
    //         'public/js/**/*.js',
    //         'public/css/**/*.css'
    //     ],
    //     watchOptions: {
    //         usePolling: true,
    //         interval: 500
    //     }
    // });
