<template>
    <nav class="navbar navbar-expand-lg sticky-top flex-md-nowrap shadow" style="background-color: #e3f2fd;">
        <div class="container-fluid">
            <router-link to="/" class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6 nuxt-link-active mini">
                <span>Laravel Vue Stater</span>
            </router-link>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <router-link :to="{ name: 'posts.index' }" class="nav-link active" aria-current="page">
                            Posts
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link :to="{ name: 'posts.create' }" class="nav-link">
                            Create Post
                        </router-link>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                           aria-expanded="false">
                            Hi, {{ user.name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#">Profile</a></li>
                            <li><a class="dropdown-item" href="#">Setting</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" :class="{ 'opacity-25': processing }" :disabled="processing"
                                   href="javascript:void(0)" @click="logout">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="d-flex align-items-stretch w-100">
        <nav class="bg-white sidebar">
            <div class="pt-3 sidebar-sticky">
                <ul id="menu" class="nav flex-column mb-2">
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <svg width="22" height="22" viewBox="0 0 22 22">
                                <path
                                    d="M17.4167 4.58333V6.41667H13.75V4.58333H17.4167ZM8.25 4.58333V10.0833H4.58333V4.58333H8.25ZM17.4167 11.9167V17.4167H13.75V11.9167H17.4167ZM8.25 15.5833V17.4167H4.58333V15.5833H8.25ZM19.25 2.75H11.9167V8.25H19.25V2.75ZM10.0833 2.75H2.75V11.9167H10.0833V2.75ZM19.25 10.0833H11.9167V19.25H19.25V10.0833ZM10.0833 13.75H2.75V19.25H10.0833V13.75Z"></path>
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#submenu2" data-bs-toggle="collapse" class="nav-link px-0 align-middle ">
                            <i class="fs-4 bi-bootstrap"></i> <span class="ms-1 d-none d-sm-inline">User Manage</span></a>
                        <ul class="collapse nav flex-column ms-1" id="submenu2" data-bs-parent="#menu">
                            <li class="nav-link w-100">
                                <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Permissions</span> 1</a>
                            </li>
                            <li class="nav-link">
                                <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Roles</span> 2</a>
                            </li>
                            <li class="nav-link">
                                <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Users</span> 2</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#submenu3" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                            <i class="fs-4 bi-grid"></i> <span class="ms-1 d-none d-sm-inline">Products</span> </a>
                        <ul class="collapse nav flex-column ms-1" id="submenu3" data-bs-parent="#menu">
                            <li class="w-100">
                                <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Product</span> 1</a>
                            </li>
                            <li>
                                <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Product</span> 2</a>
                            </li>
                            <li>
                                <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Product</span> 3</a>
                            </li>
                            <li>
                                <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Product</span> 4</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="container my-5">
            <h2 class="fw-semibold">
                {{ currentPageTitle }}
            </h2>
            <!-- Page Content -->
            <div class="main">
                <router-view></router-view>
            </div>
        </div>
    </div>
</template>

<script>
import useAuth from "../composables/auth";

export default {
    setup() {
        const {user, processing, logout} = useAuth()
        return {user, processing, logout}
    },
    computed: {
        currentPageTitle() {
            return this.$route.meta.title;
        }
    }
}
</script>

<style scoped>
.navbar-brand {
    padding-top: .2rem;
    padding-bottom: .2rem;
    min-width: 250px;
    max-width: 250px;
    align-self: stretch;
    display: flex;
    justify-content: flex-start;
    align-items: center;
    transition: all .3s linear;
}

.main-content, .sidebar {
    height: calc(100vh - 56px);
    overflow-x: hidden;
    overflow-y: auto;
}

.sidebar {
    position: relative;
    z-index: 100;
    box-shadow: 1px 0 10px rgba(0, 0, 0, .1);
    min-width: 250px;
    max-width: 250px;
    transition: all .3s linear;
}

.sidebar.mini {
    min-width: 60px;
    max-width: 60px;
}

.sidebar ul li a.active, .sidebar ul li a:hover {
    color: #4a6cf7;
    border-color: rgba(74, 108, 247, 0.15);
    background: rgba(74, 108, 247, 0.1);
}

@media (max-width: 767.98px) {
    .navbar-brand, .sidebar {
        min-width: 60px;
        max-width: 60px;
    }

    .navbar-brand {
        min-width: 60px;
        max-width: 60px;
    }

    .navbar-brand span {
        min-width: 20px;
        max-width: 20px;
        font-weight: 900;
        overflow: hidden;
    }
}
</style>
