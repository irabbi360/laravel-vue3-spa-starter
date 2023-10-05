import { createStore } from 'vuex'
import createPersistedState from 'vuex-persistedstate'
import auth from '../store/auth'
import lang from '../store/lang'

const store = createStore({
    plugins:[
        createPersistedState()
    ],
    modules:{
        auth,
        lang
    }
})

export default store
