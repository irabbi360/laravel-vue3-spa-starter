<template>
    <form @submit.prevent="submitForm">
        <!-- Title -->
        <div>
            <label for="post-title" class="block font-medium text-sm text-gray-700">
                Title
            </label>
            <input v-model="post.title" id="post-title" type="text" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            <div class="text-red-600 mt-1">
                {{ errors.title }}
            </div>
            <div class="text-red-600 mt-1">
                <div v-for="message in validationErrors?.title">
                    {{ message }}
                </div>
            </div>
        </div>
        <!-- Content -->
        <div class="mt-4">
            <label for="post-content" class="block font-medium text-sm text-gray-700">
                Content
            </label>
            <textarea v-model="post.content" id="post-content" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
            <div class="text-red-600 mt-1">
                {{ errors.content }}
            </div>
            <div class="text-red-600 mt-1">
                <div v-for="message in validationErrors?.content">
                    {{ message }}
                </div>
            </div>
        </div>
        <!-- Category -->
        <div class="mt-4">
            <label for="post-category" class="block font-medium text-sm text-gray-700">
                Category
            </label>
            <select-2 v-model="post.category_id" :options="categories" :settings="{ width: '100%' }"></select-2>
            <div class="text-red-600 mt-1">
                {{ errors.category_id }}
            </div>
            <div class="text-red-600 mt-1">
                <div v-for="message in validationErrors?.category_id">
                    {{ message }}
                </div>
            </div>
        </div>
        <div class="mt-4">
            <label for="thumbnail" class="block font-medium text-sm text-gray-700">
                Thumbnail
            </label>
            <input @change="post.thumbnail = $event.target.files[0]" type="file" id="thumbnail" />
            <div class="text-red-600 mt-1">
                <div v-for="message in validationErrors?.thumbnail">
                    {{ message }}
                </div>
            </div>
        </div>
        <!-- Buttons -->
        <div class="mt-4">
            <button :disabled="isLoading" class="inline-flex items-center px-3 py-2 bg-blue-600 text-white rounded disabled:opacity-75 disabled:cursor-not-allowed">
                <div v-show="isLoading" class="inline-block animate-spin w-4 h-4 mr-2 border-t-2 border-t-white border-r-2 border-r-white border-b-2 border-b-white border-l-2 border-l-blue-600 rounded-full"></div>
                <span v-if="isLoading">Processing...</span>
                <span v-else>Save</span>
            </button>
        </div>
    </form>
</template>
<script>
import { onMounted, reactive, watchEffect } from "vue";
import { useRoute } from "vue-router";
import useCategories from "../../composables/categories";
import usePosts from "../../composables/posts";
import { useForm, useField, defineRule } from "vee-validate";
import { required, min } from "../../validation/rules"
defineRule('required', required)
defineRule('min', min);
export default {
    setup() {
        // Define a validation schema
        const schema = {
            title: 'required|min:5',
            content: 'required|min:50',
            category_id: 'required'
        }
        // Create a form context with the validation schema
        const { validate, errors, resetForm } = useForm({ validationSchema: schema })
        // Define actual fields for validation
        const { value: title } = useField('title', null, { initialValue: '' });
        const { value: content } = useField('content', null, { initialValue: '' });
        const { value: category_id } = useField('category_id', null, { initialValue: '', label: 'category' });
        const { categories, getCategories } = useCategories()
        const { post: postData, getPost, updatePost, validationErrors, isLoading } = usePosts()
        const post = reactive({
            title,
            content,
            category_id,
            thumbnail: ''
        })
        const route = useRoute()
        function submitForm() {
            validate().then(form => { if (form.valid) updatePost(post) })
        }
        onMounted(() => {
            getPost(route.params.id)
            getCategories()
        })
        // https://vuejs.org/api/reactivity-core.html#watcheffect
        watchEffect(() => {
            post.id = postData.value.id
            post.title = postData.value.title
            post.content = postData.value.content
            post.category_id = postData.value.category_id
        })
        return {
            categories,
            post,
            validationErrors,
            isLoading,
            updatePost,
            errors,
            submitForm,
        }
    }
}
</script>
