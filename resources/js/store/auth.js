import axios from 'axios';

export default {
    namespaced: true,
    state: {
        authenticated: false,
        user: {}
    },
    getters: {
        authenticated(state) {
            return state.authenticated
        },
        user(state) {
            return state.user
        }
    },
    mutations: {
        SET_AUTHENTICATED(state, value) {
            state.authenticated = value
        },
        SET_USER(state, value) {
            state.user = value
        }
    },
    actions: {
        login({commit}) {
            return axios.get('/api/user').then(({data}) => {
                commit('SET_USER', data)
                commit('SET_AUTHENTICATED', true)
            }).catch(({res}) => {
                commit('SET_USER', {})
                commit('SET_AUTHENTICATED', false)
            })
        },
        getUser({commit}) {
            return axios.get('/api/user').then(({data}) => {
                if (data.success) {
                    commit('SET_USER', data.data)
                    commit('SET_AUTHENTICATED', true)
                    // router.push({name: 'dashboard'})
                }
                // else {
                //     commit('SET_USER', {})
                //     commit('SET_AUTHENTICATED', false)
                // }
            }).catch(({res}) => {
                commit('SET_USER', {})
                commit('SET_AUTHENTICATED', false)
            })
        },
        logout({commit}) {
            commit('SET_USER', {})
            commit('SET_AUTHENTICATED', false)
        }
    }
}
