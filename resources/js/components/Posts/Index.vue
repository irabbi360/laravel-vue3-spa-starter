<template>
    <div class="row justify-content-center my-5">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="mb-4">
                        <input v-model="search_global" type="text" placeholder="Search..."
                               class="form-control w-25">
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-left">
                                    <input v-model="search_id" type="text"
                                           class="inline-block mt-1 form-control"
                                           placeholder="Filter by ID">
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left">
                                    <input v-model="search_title" type="text"
                                           class="inline-block mt-1 form-control"
                                           placeholder="Filter by Title">
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left">
                                    <v-select v-model="search_category" :options="categories"
                                              :reduce="category => category.id" label="text" class="form-control w-100"/>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left">
                                    <input v-model="search_content" type="text"
                                           class="inline-block mt-1 form-control"
                                           placeholder="Filter by Content">
                                </th>
                                <th class="px-6 py-3 text-start"></th>
                                <th class="px-6 py-3 text-start"></th>
                            </tr>
                            <tr>
                                <th class="px-6 py-3 text-start">
                                    <div class="flex flex-row"
                                         @click="updateOrdering('id')">
                                        <div class="font-medium text-uppercase"
                                             :class="{ 'font-bold text-blue-600': orderColumn === 'id' }">
                                            ID
                                        </div>
                                        <div class="select-none">
                                <span :class="{
                                  'text-blue-600': orderDirection === 'asc' && orderColumn === 'id',
                                  'hidden': orderDirection !== '' && orderDirection !== 'asc' && orderColumn === 'id',
                                }">&uarr;</span>
                                            <span :class="{
                                  'text-blue-600': orderDirection === 'desc' && orderColumn === 'id',
                                  'hidden': orderDirection !== '' && orderDirection !== 'desc' && orderColumn === 'id',
                                }">&darr;</span>
                                        </div>
                                    </div>
                                </th>
                                <th class="px-6 py-3 text-left">
                                    <div class="flex flex-row"
                                         @click="updateOrdering('title')">
                                        <div class="font-medium text-uppercase"
                                             :class="{ 'font-bold text-blue-600': orderColumn === 'title' }">
                                            Title
                                        </div>
                                        <div class="select-none">
                                <span :class="{
                                  'text-blue-600': orderDirection === 'asc' && orderColumn === 'title',
                                  'hidden': orderDirection !== '' && orderDirection !== 'asc' && orderColumn === 'title',
                                }">&uarr;</span>
                                            <span :class="{
                                  'text-blue-600': orderDirection === 'desc' && orderColumn === 'title',
                                  'hidden': orderDirection !== '' && orderDirection !== 'desc' && orderColumn === 'title',
                                }">&darr;</span>
                                        </div>
                                    </div>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left">
                                    <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Category</span>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left">
                                    <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Content</span>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left">
                                    <div class="flex flex-row items-center justify-between cursor-pointer"
                                         @click="updateOrdering('created_at')">
                                        <div class="leading-4 font-medium text-gray-500 uppercase tracking-wider"
                                             :class="{ 'font-bold text-blue-600': orderColumn === 'created_at' }">
                                            Created at
                                        </div>
                                        <div class="select-none">
                                <span :class="{
                                  'text-blue-600': orderDirection === 'asc' && orderColumn === 'created_at',
                                  'hidden': orderDirection !== '' && orderDirection !== 'asc' && orderColumn === 'created_at',
                                }">&uarr;</span>
                                            <span :class="{
                                  'text-blue-600': orderDirection === 'desc' && orderColumn === 'created_at',
                                  'hidden': orderDirection !== '' && orderDirection !== 'desc' && orderColumn === 'created_at',
                                }">&darr;</span>
                                        </div>
                                    </div>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left">
                                    Actions
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="post in posts.data" :key="post.id">
                                <td class="px-6 py-4 text-sm">
                                    {{ post.id }}
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    {{ post.title }}
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    {{ post.category }}
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    {{ post.content }}
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    {{ post.created_at }}
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <router-link v-if="can('post-edit')"
                                                 :to="{ name: 'posts.edit', params: { id: post.id } }" class="badge bg-primary">Edit
                                    </router-link>
                                    <a href="#" v-if="can('post-delete')" @click.prevent="deletePost(post.id)"
                                       class="ml-2 badge bg-danger">Delete</a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <Pagination :data="posts" :limit="3"
                                @pagination-change-page="page => getPosts(page, search_category, search_id, search_title, search_content, search_global, orderColumn, orderDirection)"
                                class="mt-4"/>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {ref, onMounted, watch} from "vue";
import usePosts from "../../composables/posts";
import useCategories from "../../composables/categories";
import {useAbility} from '@casl/vue'

export default {
    setup() {
        const search_category = ref('')
        const search_id = ref('')
        const search_title = ref('')
        const search_content = ref('')
        const search_global = ref('')
        const orderColumn = ref('created_at')
        const orderDirection = ref('desc')
        const {posts, getPosts, deletePost} = usePosts()
        const {categories, getCategories} = useCategories()
        const {can} = useAbility()
        onMounted(() => {
            getPosts()
            getCategories()
        })
        const updateOrdering = (column) => {
            orderColumn.value = column;
            orderDirection.value = (orderDirection.value === 'asc') ? 'desc' : 'asc';
            getPosts(
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
            getPosts(
                1,
                current,
                search_id.value,
                search_title.value,
                search_content.value,
                search_global.value
            )
        })
        watch(search_id, (current, previous) => {
            getPosts(
                1,
                search_category.value,
                current,
                search_title.value,
                search_content.value,
                search_global.value
            )
        })
        watch(search_title, (current, previous) => {
            getPosts(
                1,
                search_category.value,
                search_id.value,
                current,
                search_content.value,
                search_global.value
            )
        })
        watch(search_content, (current, previous) => {
            getPosts(
                1,
                search_category.value,
                search_id.value,
                search_title.value,
                current,
                search_global.value
            )
        })
        watch(search_global, _.debounce((current, previous) => {
            getPosts(
                1,
                search_category.value,
                search_id.value,
                search_title.value,
                search_content.value,
                current
            )
        }, 200))
        return {
            posts,
            getPosts,
            deletePost,
            categories,
            search_category,
            search_id,
            search_title,
            search_content,
            search_global,
            orderColumn,
            orderDirection,
            updateOrdering,
            can
        }
    }
}
</script>
