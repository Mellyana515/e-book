/**
 * Google OAuth Login Handler
 * Handles Google Sign-In flow for the application
 */

class GoogleAuthHandler {
    constructor() {
        this.isLoading = false;
        this.init();
    }

    init() {
        // Find and attach listeners to Google login button
        const googleLoginBtn = document.getElementById("google-login-btn");
        if (googleLoginBtn) {
            googleLoginBtn.addEventListener("click", (e) =>
                this.handleGoogleLogin(e),
            );
        }

        // Check if we're on the callback page
        const params = new URLSearchParams(window.location.search);
        if (params.has("code") || params.has("state")) {
            this.handleGoogleCallback();
        }
    }

    /**
     * Handle Google login button click
     */
    async handleGoogleLogin(e) {
        e.preventDefault();

        if (this.isLoading) return;

        this.isLoading = true;
        const btn = e.currentTarget;
        const originalText = btn.innerHTML;

        try {
            // Set loading state
            btn.disabled = true;
            btn.innerHTML =
                '<span class="spinner-border spinner-border-sm me-2"></span>Redirecting...';

            // Get Google OAuth URL from backend
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
                    data.message || "Failed to get Google auth URL",
                );
            }

            // Redirect to Google OAuth
            window.location.href = data.redirect_url;
        } catch (error) {
            console.error("Google login error:", error);
            btn.disabled = false;
            btn.innerHTML = originalText;
            this.showError(error.message || "Failed to initiate Google login");
            this.isLoading = false;
        }
    }

    /**
     * Handle Google OAuth callback
     */
    async handleGoogleCallback() {
        const params = new URLSearchParams(window.location.search);
        const code = params.get("code");
        const state = params.get("state");

        if (!code) {
            const error = params.get("error") || "Unknown error";
            console.error("Google callback error:", error);
            this.showError(`Google Sign-In failed: ${error}`);
            return;
        }

        try {
            // Send code to backend for verification
            const response = await fetch("/api/auth/google/callback", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                    "X-CSRF-Token": this.getCsrfToken(),
                },
                credentials: "include",
                body: JSON.stringify({
                    code: code,
                    state: state,
                }),
            });

            const data = await response.json();

            if (!data.success) {
                throw new Error(data.message || "Authentication failed");
            }

            // Show success message
            this.showSuccess(`Welcome, ${data.user.name}!`);

            // Store token if provided
            if (data.token) {
                localStorage.setItem("api_token", data.token);
            }

            // Redirect after short delay
            setTimeout(() => {
                window.location.href = data.redirect || "/";
            }, 1500);
        } catch (error) {
            console.error("Callback error:", error);
            this.showError(
                error.message || "Failed to complete authentication",
            );
        }
    }

    /**
     * Get CSRF token from meta tag
     */
    getCsrfToken() {
        return document.querySelector('meta[name="csrf-token"]')?.content || "";
    }

    /**
     * Show error message
     */
    showError(message) {
        this.showAlert(message, "danger");
    }

    /**
     * Show success message
     */
    showSuccess(message) {
        this.showAlert(message, "success");
    }

    /**
     * Show alert
     */
    showAlert(message, type = "info") {
        // Remove existing alerts
        const existingAlert = document.querySelector(".alert");
        if (existingAlert) {
            existingAlert.remove();
        }

        const alertDiv = document.createElement("div");
        alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
        alertDiv.role = "alert";
        alertDiv.style.cssText =
            "position: fixed; top: 20px; right: 20px; z-index: 9999; max-width: 400px;";
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;

        document.body.appendChild(alertDiv);

        // Auto remove after 5 seconds
        setTimeout(() => {
            alertDiv.remove();
        }, 5000);
    }
}

// Initialize when DOM is ready
document.addEventListener("DOMContentLoaded", () => {
    new GoogleAuthHandler();
});

// Export for use in modules
if (typeof module !== "undefined" && module.exports) {
    module.exports = GoogleAuthHandler;
}
