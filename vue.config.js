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
            beatsomeone: ['./views/beatsomeone/basic/beatsomeone.js'],
            detail: ['./views/beatsomeone/basic/detail.js'],
            sublist: ['./views/beatsomeone/basic/sublist.js'],
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
                'window.jQuery': 'jquery',
                _: 'lodash',
                Http: [path.join(__dirname, 'src/http/http.js'), 'default'],
                log: [path.join(__dirname, 'src/logger.js'), 'default'],
            }]);

        config.module
            .rule('media')
            .test(/\.mp3$/)
            .use('file-loader')
            .loader('file-loader')
            .options({
                publicPath : '/dist/audio/',
                outputPath: 'audio',
                name : '[name].[ext]?[hash]',
            })
            .end()
    },

}