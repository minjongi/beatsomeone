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
            regist_item: ['./views/beatsomeone/basic/mypage/regist_item.js'],
            dashboard: ['./views/beatsomeone/basic/mypage/dashboard.js'],
            list_item: ['./views/beatsomeone/basic/mypage/list_item.js'],
            profilemod: ['./views/beatsomeone/basic/mypage/profilemod.js'],
            inquiry: ['./views/beatsomeone/basic/mypage/inquiry.js'],
            faq: ['./views/beatsomeone/basic/mypage/faq.js'],
            mybilling: ['./views/beatsomeone/basic/mypage/mybilling.js'],
            calchistory: ['./views/beatsomeone/basic/mypage/calchistory.js'],
            message: ['./views/beatsomeone/basic/mypage/message.js'],
            saleshistory: ['./views/beatsomeone/basic/mypage/saleshistory.js'],
            seller: ['./views/beatsomeone/basic/mypage/seller.js'],
            video: ['./views/beatsomeone/basic/mypage/video.js'],
            cart: ['./views/beatsomeone/basic/cart/cart.js'],
            billing: ['./views/beatsomeone/basic/cart/billing.js'],
            complete: ['./views/beatsomeone/basic/cart/complete.js'],
            status_item: ['./views/mypage/basic/status_item.js'],
            login: ['./views/login/basic/login.js'],
            register: ['./views/register/basic/register.js'],
            findaccount: ['./views/findaccount/basic/findaccount.js'],

            m_beatsomeone: ['./views/beatsomeone/mobile/beatsomeone.js'],
            m_detail: ['./views/beatsomeone/mobile/detail.js'],
            m_sublist: ['./views/beatsomeone/mobile/sublist.js'],
            m_regist_item: ['./views/beatsomeone/mobile/mypage/regist_item.js'],
            m_list_item: ['./views/beatsomeone/mobile/mypage/list_item.js'],
            m_status_item: ['./views/mypage/mobile/status_item.js'],
            m_login: ['./views/login/mobile/login.js'],
            m_register: ['./views/register/mobile/register.js'],
            m_findaccount: ['./views/findaccount/mobile/findaccount.js'],

            admin_cmallitem_write: ['./views/admin/basic/cmall/cmallitem/write.js'],
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