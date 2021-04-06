export default {
    install(Vue) {
        Vue.prototype.helper = {
            langUrl: function(lang, url) {
                return (lang === 'ko' ? '/ko' : '') + url;
            }
        }

        Vue.prototype.helper = {
            langUrl: function(lang, url) {
                return (lang === 'ko' ? '/ko' : '') + url;
            }
        }
    }
}