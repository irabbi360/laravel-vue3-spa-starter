<template>
    <div class="container">
        <div class="row justify-content-center my-5">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header">{{ $t('verify_your_email_address') }}</div>

                    <div class="card-body">
                        <!-- Loading State -->
                        <div v-if="loading" class="text-center">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-2">{{ $t('verifying_email') }}</p>
                        </div>

                        <!-- Success Message -->
                        <div v-else-if="verified" class="alert alert-success" role="alert">
                            <h4 class="alert-heading">{{ $t('email_verified_success') }}</h4>
                            <p>{{ $t('redirecting_dashboard') }}</p>
                        </div>

                        <!-- Error Message -->
                        <div v-else-if="error" class="alert alert-danger" role="alert">
                            <h4 class="alert-heading">{{ $t('verification_link_invalid') }}</h4>
                            <p>{{ error }}</p>
                        </div>

                        <!-- Resend Form -->
                        <div v-if="error">
                            <div v-if="resent" class="alert alert-success" role="alert">
                                {{ $t('fresh_verification_link_sent') }}
                            </div>

                            <p>{{ $t('before_proceeding_check_email') }}</p>
                            <p>
                                {{ $t('if_you_did_not_receive_the_email') }}
                                <button type="button" @click="resendVerificationEmail" class="btn btn-primary align-baseline" :disabled="processing">
                                    {{ $t('click_here_to_request_another') }}
                                </button>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import {useAuthStore} from "@/store/auth";

const route = useRoute();
const router = useRouter();
const authStore = useAuthStore();

const loading = ref(true);
const verified = ref(false);
const error = ref(null);
const resent = ref(false);
const processing = ref(false);

const verifyEmail = async () => {
    try {
        loading.value = true;
        const { id, hash } = route.params;

        const { expires, signature } = route.query;
        
        if (!id || !hash || !expires || !signature) {
            error.value = 'Invalid verification link.';
            loading.value = false;
            return;
        }

        const response = await axios.get(`/api/email/verify/${id}/${hash}`, {
            params: {
                expires,
                signature,
            },
        });
        
        if (response.status === 200) {
            await authStore.getUser();
            verified.value = true;
            // Redirect to dashboard after 2 seconds
            setTimeout(() => {
                router.push('/admin');
            }, 2000);
        }
    } catch (err) {
        error.value = err.response?.data?.message || 'Failed to verify email. The link may be invalid or expired.';
        loading.value = false;
    }
};

const resendVerificationEmail = async () => {
    processing.value = true;
    try {
        await axios.post('/api/email/verification-notification');
        resent.value = true;
        setTimeout(() => {
            resent.value = false;
        }, 5000);
    } catch (error) {
        console.error('Error resending verification email:', error);
    } finally {
        processing.value = false;
    }
};

onMounted(() => {
    verifyEmail();
});
</script>

<style scoped>

</style>
