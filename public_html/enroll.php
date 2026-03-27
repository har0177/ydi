<?php require 'header.php'; ?>

<?php
$db = new database();
$success = false;
$error = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enroll'])) {
    $name = cleanString($_POST['name'] ?? '');
    $email = cleanString($_POST['email'] ?? '');
    $phone = cleanString($_POST['phone'] ?? '');
    $program = cleanString($_POST['program'] ?? '');
    $message = cleanString($_POST['message'] ?? '');

    if (empty($name) || empty($email) || empty($phone) || empty($program)) {
        $error = "Please fill in all required fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
    } else {
        // Here you would typically save to database or send email
        // For now, we'll just show success
        $success = true;
    }
}

// Get programs for dropdown
$db->query("SELECT p_id, p_title FROM programs WHERE status = 1 ORDER BY p_order ASC");
$programs = [];
while ($p = $db->fetchObject()) {
    $programs[] = $p;
}
?>

<!-- Page Title Section -->
<section class="page-title-section">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="text-center">
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-4">Enroll Now</h1>
            <nav class="flex justify-center">
                <ol class="flex items-center space-x-2 text-white/80">
                    <li><a href="index.php" class="hover:text-white transition-colors">Home</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li class="text-white">Enrollment</li>
                </ol>
            </nav>
        </div>
    </div>
</section>

<!-- Enrollment Section -->
<section class="py-16 bg-white dark:bg-slate-900">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-16">
            <!-- Info Column -->
            <div>
                <span class="inline-block px-4 py-1.5 bg-primary-100 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 text-sm font-semibold rounded-full mb-4">Join Us</span>
                <h2 class="font-display text-3xl md:text-4xl font-bold text-slate-800 dark:text-white mb-6">
                    Start Your <span class="gradient-text">Learning Journey</span>
                </h2>
                <p class="text-slate-600 dark:text-slate-400 mb-8 leading-relaxed">
                    Take the first step towards your personal and professional growth. Our programs are designed to equip you with the skills and knowledge you need to succeed.
                </p>

                <!-- Benefits -->
                <div class="space-y-4 mb-8">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-slate-800 dark:text-white">Expert Trainers</h4>
                            <p class="text-slate-600 dark:text-slate-400 text-sm">Learn from industry professionals with years of experience.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-slate-800 dark:text-white">Practical Training</h4>
                            <p class="text-slate-600 dark:text-slate-400 text-sm">Hands-on experience with real-world projects and case studies.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-slate-800 dark:text-white">Certification</h4>
                            <p class="text-slate-600 dark:text-slate-400 text-sm">Receive recognized certificates upon successful completion.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-slate-800 dark:text-white">Career Support</h4>
                            <p class="text-slate-600 dark:text-slate-400 text-sm">Guidance and support for your career development.</p>
                        </div>
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="p-6 bg-slate-50 dark:bg-slate-800 rounded-2xl">
                    <h4 class="font-semibold text-slate-800 dark:text-white mb-4">Need Help?</h4>
                    <div class="space-y-3">
                        <a href="tel:+92946710711" class="flex items-center gap-3 text-slate-600 dark:text-slate-400 hover:text-primary-500 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            +92-946-710711
                        </a>
                        <a href="mailto:info@ydi.edu.pk" class="flex items-center gap-3 text-slate-600 dark:text-slate-400 hover:text-primary-500 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            info@ydi.edu.pk
                        </a>
                    </div>
                </div>
            </div>

            <!-- Form Column -->
            <div>
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl p-6 lg:p-8 border border-slate-100 dark:border-slate-700">
                    <?php if ($success) { ?>
                    <div class="text-center py-8">
                        <div class="w-20 h-20 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-800 dark:text-white mb-4">Thank You!</h3>
                        <p class="text-slate-600 dark:text-slate-400 mb-8">Your enrollment request has been submitted. Our team will contact you shortly.</p>
                        <a href="index.php" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-primary-500 to-secondary-500 text-white font-semibold rounded-xl hover:shadow-lg transition-all duration-300">
                            Back to Home
                        </a>
                    </div>
                    <?php } else { ?>
                    <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-6">Enrollment Form</h3>

                    <?php if (!empty($error)) { ?>
                    <div class="mb-6 p-4 bg-red-100 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-xl">
                        <p class="text-red-700 dark:text-red-300 font-medium flex items-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <?php echo $error; ?>
                        </p>
                    </div>
                    <?php } ?>

                    <form method="POST" action="" class="space-y-5">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Full Name <span class="text-red-500">*</span></label>
                            <input type="text" name="name" required
                                class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all"
                                placeholder="Enter your full name">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Email <span class="text-red-500">*</span></label>
                                <input type="email" name="email" required
                                    class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all"
                                    placeholder="your@email.com">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Phone <span class="text-red-500">*</span></label>
                                <input type="tel" name="phone" required
                                    class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all"
                                    placeholder="+92 XXX XXXXXXX">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Select Program <span class="text-red-500">*</span></label>
                            <select name="program" required
                                class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all">
                                <option value="">Choose a program...</option>
                                <?php foreach ($programs as $prog) { ?>
                                <option value="<?php echo (int)$prog->p_id; ?>"><?php echo htmlspecialchars($prog->p_title); ?></option>
                                <?php } ?>
                                <option value="other">Other (specify in message)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Message (Optional)</label>
                            <textarea name="message" rows="4"
                                class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all resize-none"
                                placeholder="Any additional information or questions..."></textarea>
                        </div>

                        <button type="submit" name="enroll"
                            class="w-full py-4 px-6 bg-gradient-to-r from-primary-500 to-secondary-500 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Submit Enrollment Request
                        </button>
                    </form>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require 'footer.php'; ?>
