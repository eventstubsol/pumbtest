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

mix.react('resources/js/app.js', 'public/js/chat');
mix.react('resources/js/ByLaws/App.js', 'public/js/by-laws');
mix.react('resources/js/sessionManager/index.js', 'public/js/session-manager');
mix.react('resources/js/sessionModerator/index.js', 'public/js/session-poll-app');
mix.react('resources/js/Profile/index.js', 'public/js/profile');

//Sass
mix.sass('resources/sass/custom.scss', 'public/assets/css/custom.css');
mix.sass('resources/sass/auth.scss', 'public/assets/css/auth.css');