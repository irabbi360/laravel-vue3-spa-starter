<template>
    <div class="row justify-content-center my-5">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form @submit.prevent="submitForm">
                        <!-- Title -->
                        <div class="mb-3">
                            <label for="post-title" class="form-label">
                                Title
                            </label>
                            <input v-model="role.name" id="post-title" type="text" class="form-control">
                            <div class="text-danger mt-1">
                                {{ errors.name }}
                            </div>
                            <div class="text-danger mt-1">
                                <div v-for="message in validationErrors?.name">
                                    {{ message }}
                                </div>
                            </div>
                        </div>
                        <!-- Buttons -->
                        <div class="mt-4">
                            <button :disabled="isLoading" class="btn btn-primary">
                                <div v-show="isLoading" class=""></div>
                                <span v-if="isLoading">Processing...</span>
                                <span v-else>Update</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { onMounted, reactive, watchEffect } from "vue";
import { useRoute } from "vue-router";
import useRoles from "../../../composables/roles";
import { useForm, useField, defineRule } from "vee-validate";
import { required, min } from "@/validation/rules"
defineRule('required', required)
defineRule('min', min);
export default {
    setup() {
        // Define a validation schema
        const schema = {
            name: 'required|min:3'
        }
        // Create a form context with the validation schema
        const { validate, errors, resetForm } = useForm({ validationSchema: schema })
        // Define actual fields for validation
        const { value: name } = useField('name', null, { initialValue: '' });
        const { role: postData, getRole, updateRole, validationErrors, isLoading } = useRoles()
        const role = reactive({
            name
        })
        const route = useRoute()
        function submitForm() {
            validate().then(form => { if (form.valid) updateRole(role) })
        }
        onMounted(() => {
            getRole(route.params.id)
        })
        // https://vuejs.org/api/reactivity-core.html#watcheffect
        watchEffect(() => {
            role.id = postData.value.id
            role.name = postData.value.name
        })
        return {
            role,
            validationErrors,
            isLoading,
            updateRole,
            errors,
            submitForm,
        }
    }
}
</script>
