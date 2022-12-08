import { createRouter, createWebHistory } from "vue-router";
import routes from './routes.js'
import store from '../store'

// function views (path) {
//     return () => import(/* webpackChunkName: '' */ `../views/${path}`).then(m => m.default || m)
// }

const router = createRouter({
    history: createWebHistory(),
    routes
})

router.beforeEach((to, from, next) => {

    if (store.getters.user) {
        if (to.matched.some(route => route.meta.guard === 'guest')) next({ name: 'home' })
        else next();

    } else {
        if (to.matched.some(route => route.meta.guard === 'auth')) next({ name: 'login' })
        else next();
    }
})

export default router;
