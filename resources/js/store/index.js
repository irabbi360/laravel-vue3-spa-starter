import { createStore } from 'vuex'
import createPersistedState from 'vuex-persistedstate'
import auth from '../store/auth'

const store = createStore({
    plugins:[
        createPersistedState()
    ],
    modules:{
        auth
    }
})

export default store
