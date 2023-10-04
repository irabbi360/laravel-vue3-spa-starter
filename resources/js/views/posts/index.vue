<template>
    <div class="container">
        <h2 class="text-center my-4">Blog Posts</h2>
        <div class="row mb-2">
            <table class="table">
                <thead>
                <tr>
                    <th class="px-6 py-3 bg-gray-50 text-left">
                        <input v-model="search_title" type="text"
                               class="inline-block mt-1 form-control"
                               placeholder="Filter by Title">
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left">
                        Categories:
                        <v-select multiple v-model="search_category" :options="categoryList"
                                  :reduce="category => category.id" label="name" class="form-control w-100"/>
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left">
                        <input v-model="search_content" type="text"
                               class="inline-block mt-1 form-control"
                               placeholder="Filter by Content">
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left">
                        Order By:
                        <v-select :clearable="false" v-model="orderColumn" @update:modelValue="updateOrdering" :options="sortColumnsOptions"
                                  class="form-control w-100"/>
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left">
                        <v-select :clearable="false"  @update:modelValue="updateOrdering"  v-model="orderDirection" :options="sortOrderOptions"
                                  class="form-control w-100"/>

                    </th>
                </tr>
                </thead>
            </table>
        </div>
        <div class="row mb-2">
            <div v-for="post in posts?.data" :key="post.id" class="col-md-6">
                <div
                    class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                    <div class="col p-4 d-flex flex-column position-static">
                        <strong class="d-inline-block mb-2 text-primary">World</strong>
                        <h3 class="mb-0">{{ post.title }}</h3>
                        <div class="mb-1 text-muted">Nov 12</div>
                        <p class="card-text mb-auto">{{ post.content.substring(0, 90) + "..." }}</p>
                        <router-link :to="{ name: 'public-posts.details', params: { id: post.id } }"
                                     class="stretched-link">Continue reading
                        </router-link>
                    </div>
                    <div v-if="post.image" class="col-auto d-none d-lg-block">
                        <img :src="getImageUrl(post)"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import axios from 'axios';
import {ref, onMounted, watch} from 'vue'
import usePosts from "@/composables/posts";
import _ from "lodash";
import useCategories from "@/composables/categories";

const search_category = ref('')
const search_id = ref('')
const search_title = ref('')
const search_content = ref('')
const search_global = ref('')
const orderColumn = ref('tile')
const orderDirection = ref('desc')
const {posts, getDisplayPosts} = usePosts()
const {categoryList, getCategoryList} = useCategories()


const sortColumnsOptions = ['title', 'created_at']
const sortOrderOptions = ['asc', 'desc']
function getImageUrl(post) {
    let image
    image = post.image
    return new URL(image, import.meta.url).href
}

onMounted(() => {
    getDisplayPosts()
    getCategoryList()
})

const updateOrdering = () => {
    console.log(orderDirection.value)
    console.log(orderColumn.value)
    getDisplayPosts(
        1,
        search_category.value,
        search_id.value,
        search_title.value,
        search_content.value,
        search_global.value,
        orderColumn.value,
        orderDirection.value
    );
}
watch(search_category, (current, previous) => {
    getDisplayPosts(
        1,
        current,
        search_id.value,
        search_title.value,
        search_content.value,
        search_global.value
    )
})
watch(search_id, (current, previous) => {
    getDisplayPosts(
        1,
        search_category.value,
        current,
        search_title.value,
        search_content.value,
        search_global.value
    )
})
watch(search_title, (current, previous) => {
    getDisplayPosts(
        1,
        search_category.value,
        search_id.value,
        current,
        search_content.value,
        search_global.value
    )
})
watch(search_content, (current, previous) => {
    getDisplayPosts(
        1,
        search_category.value,
        search_id.value,
        search_title.value,
        current,
        search_global.value
    )
})
watch(search_global, _.debounce((current, previous) => {
    getDisplayPosts(
        1,
        search_category.value,
        search_id.value,
        search_title.value,
        search_content.value,
        current
    )
}, 200))

</script>
