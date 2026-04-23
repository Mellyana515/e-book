<template>
    <div class="google-auth-modal">
        <!-- Modal untuk menampilkan pesan & redirect info -->
        <div
            v-if="showModal"
            class="modal fade"
            :class="{ show: showModal }"
            style="display: block; background: rgba(0, 0, 0, 0.5)"
        >
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center p-5">
                        <div class="mb-4">
                            <div
                                class="spinner-border text-primary"
                                role="status"
                            >
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        <h5 class="mb-3">Redirecting to Google Sign-In...</h5>
                        <p class="text-muted text-small">
                            You will be redirected to Google to authenticate.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Button untuk trigger Google login -->
        <button
            @click="initiateGoogleLogin"
            :disabled="isLoading"
            class="btn btn-outline-primary w-100"
        >
            <svg
                v-if="!isLoading"
                width="20"
                height="20"
                viewBox="0 0 48 48"
                class="me-2"
                style="display: inline"
            >
                <path
                    fill="#EA4335"
                    d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"
                />
                <path
                    fill="#4285F4"
                    d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"
                />
                <path
                    fill="#FBBC05"
                    d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"
                />
                <path
                    fill="#34A853"
                    d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.18 1.48-4.97 2.31-8.16 2.31-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"
                />
                <path fill="none" d="M0 0h48v48H0z" />
            </svg>
            <span v-if="!isLoading">Sign in with Google</span>
            <span v-else>
                <span class="spinner-border spinner-border-sm me-2"></span>
                Redirecting...
            </span>
        </button>

        <!-- Alert messages -->
        <div
            v-if="error"
            class="alert alert-danger alert-dismissible fade show mt-3"
            role="alert"
        >
            {{ error }}
            <button
                type="button"
                class="btn-close"
                @click="error = null"
            ></button>
        </div>
    </div>
</template>

<script>
export default {
    name: "GoogleAuthButton",
    data() {
        return {
            isLoading: false,
            showModal: false,
            error: null,
        };
    },
    methods: {
        async initiateGoogleLogin() {
            if (this.isLoading) return;

            this.isLoading = true;
            this.error = null;

            try {
                // Get Google auth URL from API
                const response = await fetch("/api/auth/google/url", {
                    method: "GET",
                    headers: {
                        Accept: "application/json",
                        "X-Requested-With": "XMLHttpRequest",
                    },
                });

                const data = await response.json();

                if (!data.success) {
                    throw new Error(
                        data.message || "Failed to initiate Google login",
                    );
                }

                // Show modal while redirecting
                this.showModal = true;

                // Redirect after short delay
                setTimeout(() => {
                    window.location.href = data.redirect_url;
                }, 500);
            } catch (error) {
                console.error("Google login error:", error);
                this.error =
                    error.message || "An error occurred during Google login";
                this.isLoading = false;
            }
        },
    },
};
</script>

<style scoped>
.google-auth-modal {
    position: relative;
}

.modal.show {
    display: block;
}

.btn {
    transition: all 0.3s ease;
}

.btn:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.btn:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}
</style>
