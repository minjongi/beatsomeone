import Vue from 'vue'
import VueI18n from 'vue-i18n'
import messages from "./i18nData";
import Vuecookies from 'vue-cookies'

Vue.use(VueI18n)


console.log('Vuecookies : ' + Vuecookies.get('locale'))

let validLocale = {'ko':'Korean', 'en':'English'}
let defaultLocale = Vuecookies.get('locale') || 'en'

console.log('defaultLocale : ' + defaultLocale)

defaultLocale = Object.prototype.hasOwnProperty.call(validLocale, defaultLocale) ? defaultLocale : 'en'
// Vuecookies.set('locale', defaultLocale)
console.log('defaultLocale1 : ' + defaultLocale)

export default new VueI18n({
  locale: defaultLocale,
  messages
})
