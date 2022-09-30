<template>
    <form @submit.prevent="submitLogin">
        <div>
            <!-- Email -->
            <div>
                <label for="email" class="block font-medium text-sm text-gray-700">
                    Email
                </label>
                <input v-model="loginForm.email" id="email" type="email" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required autofocus autocomplete="username">
                <!-- Validation Errors -->
                <div class="text-red-600 mt-1">
                    <div v-for="message in validationErrors?.email">
                        {{ message }}
                    </div>
                </div>
            </div>
            <!-- Password -->
            <div class="mt-4">
                <label for="password" class="block font-medium text-sm text-gray-700">
                    Password
                </label>
                <input v-model="loginForm.password" id="password" type="password" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required autocomplete="current-password">
                <!-- Validation Errors -->
                <div class="text-red-600 mt-1">
                    <div v-for="message in validationErrors?.password">
                        {{ message }}
                    </div>
                </div>
            </div>
            <!-- Remember me -->
            <div class="block mt-4">
                <label class="flex items-center">
                    <input type="checkbox" name="remember" v-model="loginForm.remember" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                    <span class="ml-2 text-sm text-gray-600">Remember me</span>
                </label>
            </div>

            <!-- Buttons -->
            <div class="flex items-center justify-end mt-4">
                <button class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150 ml-4" :class="{ 'opacity-25': processing }" :disabled="processing">
                    Log in
                </button>
            </div>
        </div>
    </form>
</template>

<script>
import useAuth from '../composables/auth'
export default {
    setup() {
        const { loginForm, validationErrors, processing, submitLogin } = useAuth()
        return { loginForm, validationErrors, processing, submitLogin }
    }
}
</script>
