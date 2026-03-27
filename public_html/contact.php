<?php require 'header.php'; ?>

<?php
$success = false;
$error = '';

if (isset($_POST['submit'])) {
    if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        $error = 'Invalid security token. Please try again.';
    } else {
        $name = cleanString($_POST['name'] ?? '');
        $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
        $subject = cleanString($_POST['subject'] ?? '');
        $message = cleanString($_POST['msg'] ?? '');

        if (empty($name) || empty($email) || empty($subject) || empty($message)) {
            $error = 'Please fill in all required fields.';
        } elseif (!$email) {
            $error = 'Please enter a valid email address.';
        } else {
            $success = true;
        }
    }
}

pageTitle('Contact Us', [['label' => 'Contact']]);
?>

<!-- Contact Content -->
<section class="py-16 bg-white dark:bg-slate-900">
    <div class="container mx-auto px-4 lg:px-8">
        <?php if ($success): ?>
        <div class="max-w-2xl mx-auto mb-8 p-4 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 rounded-2xl text-green-700 dark:text-green-400 text-center">
            <div class="flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="font-medium">Thank you! Your message has been sent successfully.</span>
            </div>
        </div>
        <?php endif; ?>

        <?php if ($error): ?>
        <div class="max-w-2xl mx-auto mb-8 p-4 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-2xl text-red-700 dark:text-red-400 text-center">
            <div class="flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="font-medium"><?php echo htmlspecialchars($error); ?></span>
            </div>
        </div>
        <?php endif; ?>

        <div class="grid lg:grid-cols-2 gap-12 lg:gap-20">
            <!-- Contact Info -->
            <div>
                <span class="inline-block px-4 py-1.5 bg-primary-100 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 text-sm font-semibold rounded-full mb-4">Get in Touch</span>
                <h2 class="font-display text-3xl md:text-4xl font-bold text-slate-800 dark:text-white mb-6">
                    Let's <span class="gradient-text">Connect</span>
                </h2>
                <p class="text-slate-600 dark:text-slate-400 mb-8 leading-relaxed">
                    Youth Development Institute (YDI) is KPK's premier and experienced firm with a great choice of study programs, marketing and consultancy services. Our main focus includes promoting employable skills and providing educational services to the youth.
                </p>

                <!-- Contact Details -->
                <div class="space-y-6">
                    <?php
                    $contactItems = [
                        ['icon' => 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z', 'icon2' => 'M15 11a3 3 0 11-6 0 3 3 0 016 0z', 'color' => 'primary', 'title' => 'Our Location', 'text' => 'Building #05 Behind Girls Degree College Saidu Sharif, Mingora'],
                        ['icon' => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z', 'color' => 'green', 'title' => 'Email Us', 'link' => 'mailto:info@ydi.edu.pk', 'text' => 'info@ydi.edu.pk'],
                        ['icon' => 'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z', 'color' => 'blue', 'title' => 'Call Us', 'link' => 'tel:+92946725501', 'text' => '+92-946-725501']
                    ];
                    foreach ($contactItems as $item) { ?>
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 w-12 h-12 bg-<?php echo $item['color']; ?>-100 dark:bg-<?php echo $item['color']; ?>-900/30 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-<?php echo $item['color']; ?>-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo $item['icon']; ?>"/>
                                <?php if (isset($item['icon2'])) { ?><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo $item['icon2']; ?>"/><?php } ?>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-slate-800 dark:text-white mb-1"><?php echo $item['title']; ?></h4>
                            <?php if (isset($item['link'])) { ?>
                            <a href="<?php echo $item['link']; ?>" class="text-primary-500 hover:text-primary-600 transition-colors"><?php echo $item['text']; ?></a>
                            <?php } else { ?>
                            <p class="text-slate-600 dark:text-slate-400"><?php echo $item['text']; ?></p>
                            <?php } ?>
                        </div>
                    </div>
                    <?php } ?>
                </div>

                <!-- Social Links -->
                <div class="mt-10">
                    <h4 class="font-semibold text-slate-800 dark:text-white mb-4">Follow Us</h4>
                    <div class="flex gap-3">
                        <a href="https://www.facebook.com/YDISWAT/" class="w-11 h-11 bg-blue-600 text-white rounded-xl flex items-center justify-center hover:bg-blue-700 hover:-translate-y-1 transition-all duration-300 shadow-lg shadow-blue-600/30">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a href="https://mail.google.com/a/ydi.edu.pk" class="w-11 h-11 bg-primary-500 text-white rounded-xl flex items-center justify-center hover:bg-primary-600 hover:-translate-y-1 transition-all duration-300 shadow-lg shadow-primary-500/30">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </a>
                        <a href="#" class="w-11 h-11 bg-red-600 text-white rounded-xl flex items-center justify-center hover:bg-red-700 hover:-translate-y-1 transition-all duration-300 shadow-lg shadow-red-600/30">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                        </a>
                    </div>
                </div>

                <!-- Map -->
                <div class="mt-10">
                    <h4 class="font-semibold text-slate-800 dark:text-white mb-4">Find Us</h4>
                    <div class="rounded-2xl overflow-hidden shadow-lg h-64">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3276.4953557982014!2d72.35097291524428!3d34.74523998042245!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x38dc06c0f2a3cf03%3A0x8e7f15a1c7a1f7f8!2sSaidu%20Sharif%2C%20Mingora%2C%20Pakistan!5e0!3m2!1sen!2s!4v1620000000000!5m2!1sen!2s" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" class="grayscale hover:grayscale-0 transition-all duration-500"></iframe>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="bg-slate-50 dark:bg-slate-800 rounded-3xl p-8 lg:p-10">
                <h3 class="text-2xl font-bold text-slate-800 dark:text-white mb-6">Send us a Message</h3>
                <form action="contact.php" method="POST" class="space-y-6">
                    <?php echo csrfField(); ?>
                    <?php
                    $formFields = [
                        ['name' => 'name', 'label' => 'Your Name', 'type' => 'text', 'required' => true],
                        ['name' => 'email', 'label' => 'Email Address', 'type' => 'email', 'required' => true],
                        ['name' => 'subject', 'label' => 'Subject', 'type' => 'text', 'required' => true],
                        ['name' => 'phone', 'label' => 'Phone Number (Optional)', 'type' => 'tel', 'required' => false]
                    ];
                    foreach ($formFields as $field) { ?>
                    <div>
                        <label for="contact<?php echo ucfirst($field['name']); ?>" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2"><?php echo $field['label']; ?></label>
                        <input type="<?php echo $field['type']; ?>" name="<?php echo $field['name']; ?>" id="contact<?php echo ucfirst($field['name']); ?>" <?php echo $field['required'] ? 'required' : ''; ?>
                               class="w-full px-4 py-3 bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-xl text-slate-800 dark:text-white focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-colors"
                               placeholder="Enter your <?php echo strtolower($field['label']); ?>"
                               value="<?php echo htmlspecialchars($_POST[$field['name']] ?? ''); ?>">
                    </div>
                    <?php } ?>

                    <div>
                        <label for="contactMessage" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Your Message</label>
                        <textarea name="msg" id="contactMessage" rows="5" required class="w-full px-4 py-3 bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-xl text-slate-800 dark:text-white focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-colors resize-none" placeholder="Write your message here..."><?php echo htmlspecialchars($_POST['msg'] ?? ''); ?></textarea>
                    </div>

                    <button type="submit" name="submit" class="w-full py-4 bg-gradient-to-r from-primary-500 to-secondary-500 text-white font-semibold rounded-xl shadow-lg shadow-primary-500/30 hover:shadow-xl hover:shadow-primary-500/40 hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center gap-2 btn-shine">
                        Send Message
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                    </button>
                </form>

                <div class="mt-8 pt-8 border-t border-slate-200 dark:border-slate-700">
                    <p class="text-slate-500 dark:text-slate-400 text-sm text-center">We typically respond within 24-48 hours during business days.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-16 bg-slate-50 dark:bg-slate-800">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="text-center mb-12">
            <span class="inline-block px-4 py-1.5 bg-primary-100 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 text-sm font-semibold rounded-full mb-4">FAQ</span>
            <h2 class="font-display text-3xl md:text-4xl font-bold text-slate-800 dark:text-white">
                Frequently Asked <span class="gradient-text">Questions</span>
            </h2>
        </div>

        <div class="max-w-3xl mx-auto space-y-4">
            <?php
            $faqs = [
                ['q' => 'What programs does YDI offer?', 'a' => 'YDI offers a wide range of educational and skill development programs including vocational training, professional development courses, and youth empowerment programs. Visit our Programs section for detailed information.'],
                ['q' => 'How can I enroll in a course?', 'a' => "You can enroll by visiting our office, calling us, or filling out the contact form above. Our team will guide you through the enrollment process and help you choose the right program."],
                ['q' => 'What are your office hours?', 'a' => 'Our office is open Monday through Saturday, 9:00 AM to 5:00 PM. We are closed on Sundays and public holidays.'],
                ['q' => 'Do you offer certificates?', 'a' => 'Yes, upon successful completion of our programs, participants receive certificates that are recognized by relevant authorities and can enhance their employment opportunities.']
            ];
            foreach ($faqs as $faq) { ?>
            <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden" x-data="{ open: false }">
                <button @click="open = !open" class="w-full px-6 py-4 text-left flex items-center justify-between">
                    <span class="font-semibold text-slate-800 dark:text-white"><?php echo $faq['q']; ?></span>
                    <svg class="w-5 h-5 text-primary-500 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="open" x-collapse>
                    <div class="px-6 pb-4 text-slate-600 dark:text-slate-400"><?php echo $faq['a']; ?></div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</section>

<?php require 'footer.php'; ?>
