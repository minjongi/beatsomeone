const path = require('path');

// vue.config.js
module.exports = {
    publicPath: '/dist/',
    css: {
        extract: {
            filename: '[name].css',
            chunkFilename: '[name].css',
        },
    },
    configureWebpack: {

        entry: {
            app: ['./views/beatsomeone/basic/beatsomeone.js'],
        },

        output: {
            chunkFilename: '[id].js',
            filename: '[id].js',
        },
        //watch: true,
        resolve: {
            alias: {
                '@': path.join(__dirname, 'assets/')
            }
        },
    },
    chainWebpack: config => {

        config
            .plugin('provide')
            .use(require('webpack').ProvidePlugin, [{
                $: 'jquery',
                jquery: 'jquery',
                jQuery: 'jquery',
                'window.jQuery': 'jquery'
            }]);

        config.module
            .rule('media')
            .test(/\.mp3$/)
            .use('file-loader')
            .loader('file-loader')
            .options({
                publicPath : './dist/',
                outputPath: 'audio',
                name : '[name].[ext]?[hash]',
            })
            .end()
    },

}