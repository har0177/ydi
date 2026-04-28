<?php require 'header.php'; ?>

<!-- Page Title Section -->
<section class="page-title-section">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="text-center">
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-4">Training Services</h1>
            <nav class="flex justify-center">
                <ol class="flex items-center space-x-2 text-white/80">
                    <li><a href="index.php" class="hover:text-white transition-colors">Home</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li class="text-white">Trainings</li>
                </ol>
            </nav>
        </div>
    </div>
</section>

<!-- Training Services -->
<section class="py-16 bg-white dark:bg-slate-900">
    <div class="container mx-auto px-4 lg:px-8">
        <!-- Section Header -->
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="inline-block px-4 py-1.5 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-sm font-semibold rounded-full mb-4">Professional Development</span>
            <h2 class="font-display text-3xl md:text-4xl font-bold text-slate-800 dark:text-white mb-4">
                Our <span class="gradient-text">Training Services</span>
            </h2>
            <p class="text-slate-600 dark:text-slate-400">Comprehensive training solutions to enhance skills and drive professional growth.</p>
        </div>

        <!-- Training Categories -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Teachers' Development -->
            <div class="group bg-slate-50 dark:bg-slate-800 rounded-2xl p-8 hover:shadow-xl transition-all duration-300 card-hover border-2 border-transparent hover:border-primary-500/20">
                <div class="w-16 h-16 bg-primary-100 dark:bg-primary-900/30 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-3 group-hover:text-primary-500 transition-colors">Teachers' Development</h3>
                <p class="text-slate-600 dark:text-slate-400 mb-4">Enhance teaching methodologies, classroom management, and pedagogical skills.</p>
                <button
                    type="button"
                    data-service="Teachers&#039; Development"
                    @click="enquireService = $event.currentTarget.dataset.service; enquireOpen = true"
                    class="inline-flex items-center gap-2 text-primary-500 font-medium hover:text-primary-600 transition-colors"
                >
                    Enquire Now
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </button>
            </div>

            <!-- Students' Development -->
            <div class="group bg-slate-50 dark:bg-slate-800 rounded-2xl p-8 hover:shadow-xl transition-all duration-300 card-hover border-2 border-transparent hover:border-green-500/20">
                <div class="w-16 h-16 bg-green-100 dark:bg-green-900/30 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-3 group-hover:text-green-500 transition-colors">Students' Development</h3>
                <p class="text-slate-600 dark:text-slate-400 mb-4">Build leadership skills, critical thinking, and personal development for students.</p>
                <button
                    type="button"
                    data-service="Students&#039; Development"
                    @click="enquireService = $event.currentTarget.dataset.service; enquireOpen = true"
                    class="inline-flex items-center gap-2 text-green-500 font-medium hover:text-green-600 transition-colors"
                >
                    Enquire Now
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </button>
            </div>

            <!-- English Proficiency -->
            <div class="group bg-slate-50 dark:bg-slate-800 rounded-2xl p-8 hover:shadow-xl transition-all duration-300 card-hover border-2 border-transparent hover:border-blue-500/20">
                <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900/30 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-3 group-hover:text-blue-500 transition-colors">English Proficiency</h3>
                <p class="text-slate-600 dark:text-slate-400 mb-4">Comprehensive English language training from beginner to advanced levels.</p>
                <button
                    type="button"
                    data-service="English Proficiency"
                    @click="enquireService = $event.currentTarget.dataset.service; enquireOpen = true"
                    class="inline-flex items-center gap-2 text-blue-500 font-medium hover:text-blue-600 transition-colors"
                >
                    Enquire Now
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </button>
            </div>

            <!-- Creative Writing -->
            <div class="group bg-slate-50 dark:bg-slate-800 rounded-2xl p-8 hover:shadow-xl transition-all duration-300 card-hover border-2 border-transparent hover:border-purple-500/20">
                <div class="w-16 h-16 bg-purple-100 dark:bg-purple-900/30 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-3 group-hover:text-purple-500 transition-colors">Creative Writing</h3>
                <p class="text-slate-600 dark:text-slate-400 mb-4">Develop creative writing skills for storytelling, content creation, and journalism.</p>
                <button
                    type="button"
                    data-service="Creative Writing"
                    @click="enquireService = $event.currentTarget.dataset.service; enquireOpen = true"
                    class="inline-flex items-center gap-2 text-purple-500 font-medium hover:text-purple-600 transition-colors"
                >
                    Enquire Now
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </button>
            </div>

            <!-- Film Making -->
            <div class="group bg-slate-50 dark:bg-slate-800 rounded-2xl p-8 hover:shadow-xl transition-all duration-300 card-hover border-2 border-transparent hover:border-pink-500/20">
                <div class="w-16 h-16 bg-pink-100 dark:bg-pink-900/30 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-3 group-hover:text-pink-500 transition-colors">Film Making</h3>
                <p class="text-slate-600 dark:text-slate-400 mb-4">Learn video production, editing, and storytelling through visual media.</p>
                <button
                    type="button"
                    data-service="Film Making"
                    @click="enquireService = $event.currentTarget.dataset.service; enquireOpen = true"
                    class="inline-flex items-center gap-2 text-pink-500 font-medium hover:text-pink-600 transition-colors"
                >
                    Enquire Now
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </button>
            </div>

            <!-- Photography -->
            <div class="group bg-slate-50 dark:bg-slate-800 rounded-2xl p-8 hover:shadow-xl transition-all duration-300 card-hover border-2 border-transparent hover:border-amber-500/20">
                <div class="w-16 h-16 bg-amber-100 dark:bg-amber-900/30 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-3 group-hover:text-amber-500 transition-colors">Photography</h3>
                <p class="text-slate-600 dark:text-slate-400 mb-4">Master photography techniques, lighting, and post-processing skills.</p>
                <button
                    type="button"
                    data-service="Photography"
                    @click="enquireService = $event.currentTarget.dataset.service; enquireOpen = true"
                    class="inline-flex items-center gap-2 text-amber-500 font-medium hover:text-amber-600 transition-colors"
                >
                    Enquire Now
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 bg-gradient-to-r from-blue-500 to-purple-500">
    <div class="container mx-auto px-4 lg:px-8 text-center">
        <h2 class="text-3xl font-bold text-white mb-4">Ready to Start Your Training?</h2>
        <p class="text-white/80 mb-8 max-w-2xl mx-auto">Contact us today to discuss your training needs and how we can help.</p>
        <a href="contact.php" class="inline-flex items-center gap-2 px-8 py-4 bg-white text-blue-600 font-semibold rounded-full shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            Get Started
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
            </svg>
        </a>
    </div>
</section>

<?php require 'footer.php'; ?>
