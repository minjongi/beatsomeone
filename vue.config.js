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
            m_beatsomeone: ['./views/beatsomeone/mobile/beatsomeone.js'],
            m_detail: ['./views/beatsomeone/mobile/detail.js'],
            m_sublist: ['./views/beatsomeone/mobile/sublist.js'],
        },

        output: {
            chunkFilename: '[id].js',
            filename: '[id].js',
        },
        //watch: true,
        resolve: {
            alias: {
                '@': path.join(__dirname, './'),
                '*': path.join(__dirname, './'),
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
                Vue: ['vue/dist/vue.esm.js', 'default'],
                Http: [path.join(__dirname, './src/http/http.js'), 'default'],
                log: [path.join(__dirname, './src/logger.js'), 'default'],
            }]);

        // config.module
        //     .rule('media')
        //     .test(/\.mp3$/)
        //     .use('file-loader')
        //     .loader('file-loader')
        //     .options({
        //         publicPath : '/dist/audio/',
        //         outputPath: 'audio',
        //         name : '[name].[ext]?[hash]',
        //     })
        //     .end();

        // config.module
        //     .rule('image')
        //     .test(/\.(png|jpg|gif)$/)
        //     .use('file-loader')
        //     .loader('file-loader')
        //     .options({
        //         name: '[path][name].[ext]',
        //         // context: path.resolve(__dirname, "src/"),
        //         // outputPath: 'dist/',
        //         //publicPath: '../',
        //         useRelativePaths: true
        //     })
        //     .end();
    },

}