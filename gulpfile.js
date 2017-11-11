var elixir = require('laravel-elixir');
var webpack = require('gulp-webpack');
var named = require('vinyl-named');
var webpackConfig = require('./webpack.config.js');

require('laravel-elixir-vue-2');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

gulp.task('webpack', (callback) => {

    webpack(webpackConfig);

});


elixir((mix) => {

    mix.sass('app.scss')
        .sass('index.scss','./public/css')
        .sass('share-detail.scss','./public/css')
        .sass('share-list.scss','./public/css')
        .sass('admin-manage.scss','./public/css')
        .sass('user-index.scss','./public/css')
        .sass('user-manage.scss','./public/css')
        .task('webpack', 'resources/assets/js/*');
});

