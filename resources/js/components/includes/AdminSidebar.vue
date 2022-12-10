<template>
    <nav class="bg-white sidebar">
        <div class="pt-3 sidebar-sticky">
            <ul id="menu" class="nav flex-column mb-2">
                <li class="nav-item">
                    <router-link to="/admin" class="nav-link">
                        <svg width="22" height="22" viewBox="0 0 22 22">
                            <path
                                d="M17.4167 4.58333V6.41667H13.75V4.58333H17.4167ZM8.25 4.58333V10.0833H4.58333V4.58333H8.25ZM17.4167 11.9167V17.4167H13.75V11.9167H17.4167ZM8.25 15.5833V17.4167H4.58333V15.5833H8.25ZM19.25 2.75H11.9167V8.25H19.25V2.75ZM10.0833 2.75H2.75V11.9167H10.0833V2.75ZM19.25 10.0833H11.9167V19.25H19.25V10.0833ZM10.0833 13.75H2.75V19.25H10.0833V13.75Z"></path>
                        </svg>
                        Dashboard
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link :to="{ name: 'posts.index' }" class="nav-link">
                        Posts
                    </router-link>
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
</template>

<script>
export default {
    name: "AdminSidebar"
}
</script>

<style scoped>

</style>
