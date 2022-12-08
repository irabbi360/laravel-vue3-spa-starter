import AuthenticatedLayout from "../layouts/Authenticated.vue";
import AdminLayout from "../layouts/Admin.vue";
import GuestLayout from "../layouts/Guest.vue";
import ErrorLayout from "../layouts/Error.vue";

import PostsIndex from '../components/Posts/Index.vue'
import PostsCreate from '../components/Posts/Create.vue'
import PostsEdit from '../components/Posts/Edit.vue'

export default [
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
                path: 'login',
                name: 'login',
                component: () => import('../components/Login.vue')
            },
        ]
    },
    {
        path: '/admin',
        component: AuthenticatedLayout,
        redirect: {
            name: 'admin.index'
        },
        name: 'admin',
        meta: {
            guard: 'auth'
        },
        children: [
            {
                path: '/admin',
                name: 'admin.index',
                component: () => import('../views/home/admin/index.vue'),
                meta: { title: 'Admin' }
            },
            {
                path: 'posts',
                name: 'posts.index',
                component: PostsIndex,
                meta: { title: 'Posts' }
            },
            {
                path: 'posts/create',
                name: 'posts.create',
                component: PostsCreate,
                meta: { title: 'Add new post' }
            },
            {
                path: 'posts/edit/:id',
                name: 'posts.edit',
                component: PostsEdit,
                meta: { title: 'Edit post' }
            },
        ]
    },
    {
        path: "/:pathMatch(.*)*",
        name: 'NotFound',
        component: () => import("../views/errors/404.vue"),

    },
];
