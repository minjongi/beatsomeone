import Vue from 'vue'
import VueI18n from 'vue-i18n'
import messages from "./i18nData";

Vue.use(VueI18n)

let defaultLocale = 'ko'

export default new VueI18n({
  locale: defaultLocale,
  messages
})
