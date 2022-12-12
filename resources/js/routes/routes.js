import Cookies from 'js-cookie'

import AuthenticatedLayout from "../layouts/Authenticated.vue";
import AdminLayout from "../layouts/Admin.vue";
import GuestLayout from "../layouts/Guest.vue";
import ErrorLayout from "../layouts/Error.vue";

import PostsIndex from '../views/admin/posts/Index.vue'
import PostsCreate from '../views/admin/posts/Create.vue'
import PostsEdit from '../views/admin/posts/Edit.vue'


function auth(to, from, next) {
    if (Cookies.get('loggedIn')) {
        next()
    }
    next('/login')
}

function guest(to, from, next) {
    if (Cookies.get('loggedIn')) {
        next('/')
    }
    next()
}

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
                component: () => import('../views/login/Login.vue'),
                beforeEnter: guest,
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
        beforeEnter: auth,
        children: [
            {
                path: '/admin',
                name: 'admin.index',
                component: () => import('../views/admin/index.vue'),
                meta: { breadCrumb: 'Admin' }
            },
            {
                path: 'posts',
                name: 'posts.index',
                component: PostsIndex,
                meta: { breadCrumb: 'Posts' }
            },
            {
                path: 'posts/create',
                name: 'posts.create',
                component: PostsCreate,
                meta: { breadCrumb: 'Add new post' }
            },
            {
                path: 'posts/edit/:id',
                name: 'posts.edit',
                component: PostsEdit,
                meta: { breadCrumb: 'Edit post' }
            },
            {
                path: 'permissions',
                name: 'permissions.index',
                component: () => import('../views/admin/permissions/index.vue'),
                meta: { breadCrumb: 'Permissions' }
            },
            {
                path: 'roles',
                name: 'roles.index',
                component: () => import('../views/admin/roles/index.vue'),
                meta: { breadCrumb: 'Roles' }
            },
            {
                path: 'users',
                name: 'users.index',
                component: () => import('../views/admin/users/index.vue'),
                meta: { breadCrumb: 'Users' }
            },
        ]
    },
    {
        path: "/:pathMatch(.*)*",
        name: 'NotFound',
        component: () => import("../views/errors/404.vue"),
    },
];
