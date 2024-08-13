import { createStore } from 'vuex'
import createPersistedState from 'vuex-persistedstate'
import lang from '../store/lang'

const store = createStore({
    plugins:[
        createPersistedState()
    ],
    modules:{
        lang
    }
})

export default store
