const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss'),
    ])
    .webpackConfig(require('./webpack.config'));

mix.copyDirectory('resources/images', 'public/images');

mix.copy('resources/js/intlTelInput.js', 'public/js');
mix.copy('resources/js/utils.js', 'public/js');
mix.copy('resources/js/bootstrap.js', 'public/js');
mix.copy('resources/js/prism.js', 'public/js');

mix.copy('resources/css/intlTelInput.css', 'public/css');
mix.copy('resources/css/prism.css', 'public/css');
