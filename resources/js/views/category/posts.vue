<template>
    <div class="container">
        <h2 class="text-center my-4">Blog Posts</h2>
        <div class="row mb-2">
            <div v-for="post in posts?.data" :key="post.id" class="col-md-6">
                <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                    <div class="col p-4 d-flex flex-column position-static">
                        <strong class="d-inline-block mb-2 text-primary">World</strong>
                        <h3 class="mb-0">{{ post.title }}</h3>
                        <div class="mb-1 text-muted">Nov 12</div>
                        <p class="card-text mb-auto">{{ post.content.substring(0,90)+"..."}}</p>
                        <router-link :to="{ name: 'public-posts.details', params: { id: post.id } }" class="stretched-link">Continue reading</router-link>
                    </div>
                    <div class="col-auto d-none d-lg-block">
                        <svg class="bd-placeholder-img" width="200" height="250" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"></rect><text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text></svg>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import axios from 'axios';
import { ref, onMounted } from 'vue'
import { useRoute } from "vue-router";

    const route = useRoute();
    const posts = ref();

    onMounted(() => {
        axios.get('/api/get-category-posts/' + route.params.id).then(({ data }) => {
            posts.value = data;
        })
    })
</script>
