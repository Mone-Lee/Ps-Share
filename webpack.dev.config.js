var path = require('path');
var webpack = require('webpack');
var ExtractTextPlugin = require('extract-text-webpack-plugin');

var projectRoot = path.resolve(__dirname, './');

module.exports = {

    entry: {
        app: 'assets/app.js',
        userIndex: 'assets/user-index.js',
        userManage:'assets/user-manage.js',
        adminManage:'assets/admin-manage.js',
        index:'assets/index.js',
        shareDetail:'assets/share-detail.js',
        shareList:'assets/share-list.js'

    },
    output: {
        path: projectRoot + '/public/js',
        publicPath: '/',
        filename:'[name].js',
        chunkFilename: '[id].[name].js'
    },
    module: {
        //加载器配置
        loaders: [
            {
                test: /\.vue$/, 
                loader: 'vue'
            },
            {
                test: /\.css$/,
                loader: 'style-loader!css-loader',
            },
            {
                test: /\.json$/,
                loader: 'json'
            },
            // laravel框架默认用buble，改成babel才能使用更多ES6的新特性
            {
                test: /\.js$/,
                loader: 'babel',
                include: projectRoot,
                exclude: /node_modules/
            },
            {
                test: /\.scss$/,
                loader: 'style!css!sass?sourceMap'
            }
        ]
    },
    // 配置应用层的模块（要被打包的模块）解析
    resolve: {
        // 这样就无需写后缀
        extensions: ['', '.js', '.vue'],
        // 解决当出现 Node.js 模块依赖查找失败的情况
        fallback: [path.join(__dirname, '../node_modules')],
        // 路径别名
        alias: {
            'vue$': 'vue/dist/vue',
            'assets': path.resolve(__dirname, './resources/assets/js'),
            'components': path.resolve(__dirname, './resources/assets/js/components')
        }
    },
    // 用来配置 loader 模块的解析
    resolveLoader: {
        // 解决当出现 Node.js 模块依赖查找失败的情况
        fallback: [path.join(__dirname, '../node_modules')]
    },

    // vue-loader 配置
    vue: {
        // ... 其他 vue 选项
        loaders: {
            // 用 babel-loader 加载所有没有 "lang" 属性的 <script>
            js: 'babel',
        }
    },

    // 插件项
    plugins: [
        // new ExtractTextPlugin('css/style.css'),
    ]
};