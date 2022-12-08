import { createRouter, createWebHistory } from "vue-router";

// function views (path) {
//     return () => import(/* webpackChunkName: '' */ `../views/${path}`).then(m => m.default || m)
// }

import AuthenticatedLayout from "../layouts/Authenticated.vue";
import AdminLayout from "../layouts/Admin.vue";
import GuestLayout from "../layouts/Guest.vue";
import ErrorLayout from "../layouts/Error.vue";

import PostsIndex from '../components/Posts/Index.vue'
import PostsCreate from '../components/Posts/Create.vue'
import PostsEdit from '../components/Posts/Edit.vue'
import Login from '../components/Login.vue'

function auth(to, from, next) {
    if (JSON.parse(localStorage.getItem('loggedIn'))) {
        next()
    }

    next('/login')
}

const routes = [
    {
        path: '/',
        // redirect: { name: 'login' },
        component: GuestLayout,
        children: [
            {
                path: '/',
                name: 'home',
                component: () => import('../views/home/index.vue'),
            },
            {
                path: '/login',
                name: 'login',
                component: () => import('../components/Login.vue')
            },
        ]
    },
    {
        path: '/admin/posts',
        component: AuthenticatedLayout,
        beforeEnter: auth,
        children: [
            {
                path: '/admin/posts',
                name: 'posts.index',
                component: PostsIndex,
                meta: { title: 'Posts' }
            },
            {
                path: '/admin/posts/create',
                name: 'posts.create',
                component: PostsCreate,
                meta: { title: 'Add new post' }
            },
            {
                path: '/admin/posts/edit/:id',
                name: 'posts.edit',
                component: PostsEdit,
                meta: { title: 'Edit post' }
            },
        ]
    },
    /**
     * Admin routes
     */
    /*{
        path: '/admin',
        component: AdminLayout,
        beforeEnter: auth,
        children: [
            {
                path: '/admin',
                name: 'admin.index',
                component: () => import('../components/Admin/Index.vue'),
                meta: { title: 'Admin Dashboard' }
            },
            {
                path: '/admin/edit',
                name: 'admin.edit',
                component: () => import('../components/Admin/Edit.vue'),
                meta: { title: 'Admin Dashboard' }
            },
        ]
    },*/
    {
        path: "/:pathMatch(.*)*",
        name: 'NotFound',
        component: () => import("../views/errors/404.vue"),

    },
]

export default createRouter({
    history: createWebHistory(),
    routes
})
