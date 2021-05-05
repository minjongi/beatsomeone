export default {
    install(Vue) {
        Vue.prototype.helper = {
            langUrl: function(lang, url) {
                return '/' + lang + url
            }
        }
    }
}
