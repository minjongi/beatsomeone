import Vue from 'vue'
import VueI18n from 'vue-i18n'
import messages from "./i18nData";
import Vuecookies from 'vue-cookies'

Vue.use(VueI18n)

let validLocale = {'ko':'Korean', 'en':'English'}
let defaultLocale = Vuecookies.get('locale') || navigator.language.split('-')[0]
defaultLocale = Object.prototype.hasOwnProperty.call(validLocale, defaultLocale) ? defaultLocale : 'ko'
Vuecookies.set('locale', defaultLocale)

export default new VueI18n({
  locale: defaultLocale,
  messages
})
