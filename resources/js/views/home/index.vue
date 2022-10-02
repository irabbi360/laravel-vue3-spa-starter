<template>
    <div>
        <Nav />
        <div class="masthead">
            <div class="text-center text-white">
                <h1 class="py-5 home-title">
                    Welcome to Laravel 8 & Vue.js Admin Dashboard
                </h1>
            </div>
        </div>
        <div class="container">
            <div class="text-center py-5 min-vh-50">
                <router-link to="/admin" class="btn btn-primary">
                    Go to dashboard <i class="fas fa-chevron-right"></i
                ></router-link>
            </div>
        </div>
        <Footer />
    </div>
</template>

<script>
import Nav from "../../components/Nav.vue";
import Footer from "../../components/Footer.vue";

export default {
    name: "HomeIndex",
    components: {
        Nav,
        Footer,
    },
}
</script>

<style scoped>
.home-title {
    font-size: 4rem;
}
.masthead {
    background: linear-gradient(0deg, #4e73df 0%, #36b9cc 100%);
    padding-top: 5rem;
    padding-bottom: 5rem;
}
.min-vh-50 {
    min-height: 50vh !important;
}
</style>
