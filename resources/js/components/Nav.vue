<template>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light nav-fill w-100">
            <div class="container">
                <button
                    class="navbar-toggler"
                    type="button"
                    data-toggle="collapse"
                    data-target="#navbarTogglerDemo01"
                    aria-controls="navbarTogglerDemo01"
                    aria-expanded="false"
                    aria-label="Toggle navigation"
                >
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                    <router-link class="navbar-brand" to="/">Home</router-link>
                    <ul class="navbar-nav mt-2 mt-lg-0 ml-auto" v-if="!user">
                        <li class="nav-item active">
                            <router-link class="nav-link" to="/login"
                            >Login <span class="sr-only">(current)</span></router-link
                            >
                        </li>
                        <li class="nav-item">
                            <router-link class="nav-link" to="/register">Sign Up</router-link>
                        </li>
                    </ul>
                    <ul class="navbar-nav mt-2 mt-lg-0 ml-auto" v-if="user">
                        <li class="nav-item active">
                            <a class="nav-link" href="javascript:void(0)" @click="logout"
                            >Logout <span class="sr-only">(current)</span></a
                            >
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
</template>

<script>
import { mapGetters } from "vuex";
import useAuth from "../composables/auth";

export default {
    name: 'Nav',
    setup() {
        const { user, processing, logout } = useAuth()
        return { user, processing, logout }
    },
    computed: {
        currentPageTitle() {
            return this.$route.meta.title;
        }
    }
}
</script>
