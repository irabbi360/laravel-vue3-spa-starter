import { ref } from 'vue'

export default function useCategories() {
    const categories = ref([])

    const getCategories = async () => {
        axios.get('/api/categories')
            .then(response => {
                categories.value = response.data.data;
                console.log(categories.value, 'categories')
            })
    }

    return { categories, getCategories }
}
