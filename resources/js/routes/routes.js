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
        // redirect: {
        //     name: 'admin.index'
        // },
        beforeEnter: auth,
        children: [
            {
                name: 'admin.index',
                path: '/admin',
                component: () => import('../views/admin/index.vue'),
                meta: { breadCrumb: 'Admin' }
            },
            {
                name: 'posts.index',
                path: 'posts',
                component: PostsIndex,
                meta: { breadCrumb: 'Posts' }
            },
            {
                name: 'posts.create',
                path: 'posts/create',
                component: PostsCreate,
                meta: { breadCrumb: 'Add new post' }
            },
            {
                name: 'posts.edit',
                path: 'posts/edit/:id',
                component: PostsEdit,
                meta: { breadCrumb: 'Edit post' }
            },
            {
                name: 'categories.index',
                path: 'categories',
                component: () => import('../views/admin/categories/index.vue'),
                meta: { breadCrumb: 'Categories' }
            },
            {
                name: 'categories.create',
                path: 'categories/create',
                component: () => import('../views/admin/categories/create.vue'),
                meta: { breadCrumb: 'Add new category' }
            },
            {
                name: 'categories.edit',
                path: 'categories/edit/:id',
                component: () => import('../views/admin/categories/edit.vue'),
                meta: { breadCrumb: 'Edit Category' }
            },
            {
                name: 'permissions.index',
                path: 'permissions',
                component: () => import('../views/admin/permissions/index.vue'),
                meta: { breadCrumb: 'Permissions' }
            },
            {
                name: 'roles.index',
                path: 'roles',
                component: () => import('../views/admin/roles/index.vue'),
                meta: { breadCrumb: 'Roles' }
            },
            {
                name: 'users.index',
                path: 'users',
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
