import { ref, inject } from 'vue'
import { useRouter } from 'vue-router'

export default function useRoles() {
    const roles = ref([])
    const role = ref({
        name: ''
    })

    const router = useRouter()
    const validationErrors = ref({})
    const isLoading = ref(false)
    const swal = inject('$swal')

    const getRoles = async (
        page = 1,
        search_id = '',
        search_title = '',
        search_global = '',
        order_column = 'created_at',
        order_direction = 'desc'
    ) => {
        axios.get('/api/roles?page=' + page +
            '&search_id=' + search_id +
            '&search_title=' + search_title +
            '&search_global=' + search_global +
            '&order_column=' + order_column +
            '&order_direction=' + order_direction)
            .then(response => {
                roles.value = response.data;
            })
    }

    const getRole = async (id) => {
        axios.get('/api/roles/' + id)
            .then(response => {
                role.value = response.data.data;
            })
    }

    const storeRole = async (role) => {
        if (isLoading.value) return;

        isLoading.value = true
        validationErrors.value = {}

        axios.post('/api/roles', role)
            .then(response => {
                router.push({name: 'roles.index'})
                swal({
                    icon: 'success',
                    title: 'Role saved successfully'
                })
            })
            .catch(error => {
                if (error.response?.data) {
                    validationErrors.value = error.response.data.errors
                }
            })
            .finally(() => isLoading.value = false)
    }

    const updateRole = async (role) => {
        if (isLoading.value) return;

        isLoading.value = true
        validationErrors.value = {}

        axios.put('/api/roles/' + role.id, role)
            .then(response => {
                router.push({name: 'roles.index'})
                swal({
                    icon: 'success',
                    title: 'Role updated successfully'
                })
            })
            .catch(error => {
                if (error.response?.data) {
                    validationErrors.value = error.response.data.errors
                }
            })
            .finally(() => isLoading.value = false)
    }

    const deleteRole = async (id) => {
        swal({
            title: 'Are you sure?',
            text: 'You won\'t be able to revert this action!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            confirmButtonColor: '#ef4444',
            timer: 20000,
            timerProgressBar: true,
            reverseButtons: true
        })
            .then(result => {
                if (result.isConfirmed) {
                    axios.delete('/api/roles/' + id)
                        .then(response => {
                            getRoles()
                            router.push({name: 'roles.index'})
                            swal({
                                icon: 'success',
                                title: 'Role deleted successfully'
                            })
                        })
                        .catch(error => {
                            swal({
                                icon: 'error',
                                title: 'Something went wrong'
                            })
                        })
                }
            })
    }

    return {
        roles,
        role,
        getRoles,
        getRole,
        storeRole,
        updateRole,
        deleteRole,
        validationErrors,
        isLoading
    }
}
