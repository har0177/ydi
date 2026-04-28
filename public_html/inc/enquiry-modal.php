<?php
/**
 * Enquiry Modal Partial
 * Included from footer.php. Reads Alpine state `enquireOpen` and `enquireService`
 * from the root <body> x-data scope (defined in header.php).
 */
?>
<div
    x-show="enquireOpen"
    x-cloak
    @keydown.escape.window="enquireOpen = false"
    class="fixed inset-0 z-[100] flex items-center justify-center p-4 overflow-y-auto"
    style="display:none;"
>
    <!-- Backdrop -->
    <div
        @click="enquireOpen = false"
        x-show="enquireOpen"
        x-transition.opacity
        class="absolute inset-0 bg-slate-900/70 backdrop-blur-sm"
    ></div>

    <!-- Card -->
    <div
        x-show="enquireOpen"
        x-transition
        x-data="enquiryForm()"
        class="relative w-full max-w-lg bg-white dark:bg-slate-800 rounded-2xl shadow-2xl overflow-hidden my-8"
    >
        <!-- Header -->
        <div class="flex items-start justify-between p-6 border-b border-slate-200 dark:border-slate-700">
            <div>
                <h3 class="text-xl font-bold text-slate-800 dark:text-white">Enquire Now</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1" x-show="!submitted && enquireService" x-cloak>
                    About: <span class="font-medium text-primary-500" x-text="enquireService"></span>
                </p>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1" x-show="!submitted && !enquireService" x-cloak>
                    Tell us how we can help.
                </p>
            </div>
            <button
                type="button"
                @click="enquireOpen = false"
                class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors"
                aria-label="Close"
            >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Form -->
        <form
            x-show="!submitted"
            @submit.prevent="submit"
            class="p-6 space-y-4"
        >
            <?php echo csrfField(); ?>
            <input type="hidden" name="bcheck" value="true">
            <input type="hidden" name="is_enquiry" value="1">

            <!-- Name -->
            <div>
                <label for="enquireName" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Name</label>
                <input
                    type="text" name="name" id="enquireName" required
                    class="w-full px-4 py-2.5 bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-slate-800 dark:text-white focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-colors"
                    placeholder="Your full name"
                >
            </div>

            <!-- Phone -->
            <div>
                <label for="enquirePhone" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Phone Number</label>
                <input
                    type="tel" name="phone" id="enquirePhone" required
                    pattern="[0-9 +\-()]{6,32}"
                    class="w-full px-4 py-2.5 bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-slate-800 dark:text-white focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-colors"
                    placeholder="e.g. +92 300 1234567"
                >
            </div>

            <!-- Email -->
            <div>
                <label for="enquireEmail" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Email</label>
                <input
                    type="email" name="email" id="enquireEmail" required
                    class="w-full px-4 py-2.5 bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-slate-800 dark:text-white focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-colors"
                    placeholder="you@example.com"
                >
            </div>

            <!-- Service (editable; pre-filled when triggered from a specific card) -->
            <div>
                <label for="enquireServiceField" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Service</label>
                <input
                    type="text" name="service" id="enquireServiceField" required
                    x-model="enquireService"
                    class="w-full px-4 py-2.5 bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-slate-800 dark:text-white focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-colors"
                    placeholder="e.g. IELTS Training, English Proficiency"
                >
            </div>

            <!-- Message -->
            <div>
                <label for="enquireMessage" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Message / Query</label>
                <textarea
                    name="message" id="enquireMessage" rows="4" required
                    class="w-full px-4 py-2.5 bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-slate-800 dark:text-white focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-colors resize-none"
                    placeholder="Tell us what you'd like to know..."
                ></textarea>
            </div>

            <!-- Inline error -->
            <div x-show="errorMessage" x-cloak class="p-3 rounded-lg bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-sm text-red-700 dark:text-red-300" x-text="errorMessage"></div>

            <!-- Submit -->
            <button
                type="submit"
                :disabled="submitting"
                class="w-full py-3 bg-gradient-to-r from-primary-500 to-secondary-500 text-white font-semibold rounded-xl shadow-lg shadow-primary-500/30 hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center gap-2 disabled:opacity-60 disabled:cursor-not-allowed disabled:translate-y-0"
            >
                <span x-show="!submitting">Submit Enquiry</span>
                <span x-show="submitting" x-cloak class="flex items-center gap-2">
                    <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                    Sending...
                </span>
            </button>
        </form>

        <!-- Success state -->
        <div x-show="submitted" x-cloak class="p-8 text-center" data-test="enquiry-success">
            <div class="w-16 h-16 mx-auto mb-4 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center">
                <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <h4 class="text-lg font-bold text-slate-800 dark:text-white mb-2">Thank you!</h4>
            <p class="text-slate-600 dark:text-slate-400 mb-6">Thank you for contacting us. Our customer service team will get back to you soon.</p>
            <button
                type="button"
                @click="enquireOpen = false; resetForm()"
                class="px-6 py-2.5 bg-primary-500 text-white font-medium rounded-lg hover:bg-primary-600 transition-colors"
            >
                Close
            </button>
        </div>
    </div>
</div>

<script>
function enquiryForm() {
    return {
        submitting: false,
        submitted: false,
        errorMessage: '',
        async submit(event) {
            this.errorMessage = '';
            this.submitting = true;
            try {
                const formData = new FormData(event.target);
                const response = await fetch('send_email.php', {
                    method: 'POST',
                    body: formData
                });
                if (response.ok) {
                    this.submitted = true;
                    event.target.reset();
                } else {
                    const text = await response.text();
                    this.errorMessage = text || 'Failed to send. Please try again.';
                }
            } catch (err) {
                this.errorMessage = 'Network error. Please try again.';
            } finally {
                this.submitting = false;
            }
        },
        resetForm() {
            this.submitted = false;
            this.errorMessage = '';
        }
    };
}
</script>
