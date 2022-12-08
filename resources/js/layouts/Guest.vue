<template>
    <Navbar/>
    <router-view></router-view>
</template>
<script setup>
import { defineAsyncComponent } from 'vue'

const Navbar = defineAsyncComponent(() =>
    import('../components/Nav.vue')
)

</script>
