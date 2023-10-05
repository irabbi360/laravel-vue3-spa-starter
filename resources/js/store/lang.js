import Cookies from 'js-cookie'

const { locale, locales } = window.config

export default {
    namespaced: true,
    state: {
        locale: getLocale(locales, locale),
        locales: locales
    },
    getters: {
        locale: state => state.locale,
        locales: state => state.locales
    },
    mutations: {
        SET_LOCALE(state, { locale }) {
            state.locale = locale
        }
    },
    actions: {
        setLocale ({ commit }, { locale }) {
            commit('SET_LOCALE', { locale })

            Cookies.set('locale', locale, { expires: 365 })
        }
    }
}

/**
 * @param  {String[]} locales
 * @param  {String} fallback
 * @return {String}
 */
function getLocale (locales, fallback) {
    const locale = Cookies.get('locale')

    if (Object.prototype.hasOwnProperty.call(locales, locale)) {
        return locale
    } else if (locale) {
        Cookies.remove('locale')
    }

    return fallback
}
