<?php
// Fetch slider data
$sliderData = new database();
$sliderData->query("SELECT * FROM slider ORDER BY id ASC");
$slides = [];
while ($slide = $sliderData->fetchObject()) {
    $slides[] = $slide;
}
$totalSlides = count($slides);
?>

<!-- Hero Section -->
<section class="relative min-h-[80vh] lg:min-h-[90vh] flex items-center overflow-hidden" x-data="{ currentSlide: 0 }" x-init="setInterval(() => { currentSlide = (currentSlide + 1) % <?php echo $totalSlides ?: 1; ?> }, 5000)">

    <!-- Background Slides -->
    <div class="absolute inset-0">
        <?php foreach ($slides as $index => $slide) { ?>
        <div class="absolute inset-0 transition-opacity duration-1000"
             :class="currentSlide === <?php echo $index; ?> ? 'opacity-100 z-10' : 'opacity-0 z-0'">
            <!-- Background Image -->
            <img src="<?php echo htmlspecialchars($slide->image); ?>" alt="YDI Slide" class="w-full h-full object-cover">
            <!-- Gradient Overlay -->
            <div class="absolute inset-0 bg-gradient-to-r from-slate-900/90 via-slate-900/70 to-transparent"></div>
        </div>
        <?php } ?>

        <?php if (empty($slides)) { ?>
        <!-- Default background if no slides -->
        <div class="absolute inset-0 bg-gradient-to-r from-primary-600 to-secondary-600"></div>
        <?php } ?>
    </div>

    <!-- Floating decorative shapes -->
    <div class="absolute top-20 right-20 w-72 h-72 bg-primary-500/20 rounded-full blur-3xl animate-float hidden lg:block"></div>
    <div class="absolute bottom-20 left-20 w-96 h-96 bg-secondary-500/20 rounded-full blur-3xl animate-float hidden lg:block" style="animation-delay: 2s;"></div>

    <!-- Content -->
    <div class="relative z-20 container mx-auto px-4 lg:px-8">
        <div class="max-w-3xl">
            <?php if (!empty($slides)) { ?>
            <!-- Dynamic Text Content for Each Slide -->
            <?php foreach ($slides as $index => $slide) { ?>
            <div class="space-y-6 transition-opacity duration-700"
                 :class="currentSlide === <?php echo $index; ?> ? 'opacity-100' : 'opacity-0 absolute'">
                <h1 class="font-display text-4xl md:text-5xl lg:text-6xl xl:text-7xl font-bold text-white leading-tight">
                    <span class="block"><?php echo htmlspecialchars($slide->title1 ?? 'Welcome to'); ?></span>
                    <span class="block gradient-text"><?php echo htmlspecialchars($slide->title2 ?? 'Youth Development Institute'); ?></span>
                </h1>

                <p class="text-lg md:text-xl text-slate-300 max-w-xl">
                    <?php echo htmlspecialchars($slide->title3 ?? 'Empowering youth through education, training, and development programs.'); ?>
                </p>

                <div class="flex flex-wrap gap-4 pt-4">
                    <a href="#ourCourses" class="group inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-primary-500 to-primary-600 text-white font-semibold rounded-full shadow-lg shadow-primary-500/30 hover:shadow-xl hover:shadow-primary-500/40 hover:-translate-y-1 transition-all duration-300 btn-shine">
                        Explore Programs
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                    <a href="contact.php" class="inline-flex items-center gap-2 px-8 py-4 bg-white/10 backdrop-blur-sm text-white font-semibold rounded-full border border-white/20 hover:bg-white/20 hover:-translate-y-1 transition-all duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        Contact Us
                    </a>
                </div>
            </div>
            <?php } ?>
            <?php } else { ?>
            <!-- Default content if no slides -->
            <div class="space-y-6 animate-slide-up">
                <h1 class="font-display text-4xl md:text-5xl lg:text-6xl xl:text-7xl font-bold text-white leading-tight">
                    <span class="block">Welcome to</span>
                    <span class="block gradient-text">Youth Development Institute</span>
                </h1>
                <p class="text-lg md:text-xl text-slate-300 max-w-xl">
                    Empowering youth through education, training, and development programs.
                </p>
            </div>
            <?php } ?>

            <!-- Slide Indicators -->
            <?php if ($totalSlides > 1) { ?>
            <div class="flex gap-2 mt-12">
                <?php for ($i = 0; $i < $totalSlides; $i++) { ?>
                <button @click="currentSlide = <?php echo $i; ?>"
                        class="h-1.5 rounded-full transition-all duration-300"
                        :class="currentSlide === <?php echo $i; ?> ? 'bg-primary-500 w-20' : 'bg-white/30 hover:bg-white/50 w-12'"
                        aria-label="Go to slide <?php echo $i + 1; ?>"></button>
                <?php } ?>
            </div>
            <?php } ?>
        </div>
    </div>

    <!-- Wave bottom -->
    <div class="wave-bg"></div>
</section>

<!-- Quick Links Section -->
<section class="relative -mt-16 z-20 pb-8 hidden md:block">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
            <!-- Clients Card -->
            <a href="#ourClients" class="group relative p-6 bg-white dark:bg-slate-800 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-primary-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <div class="relative">
                    <div class="w-14 h-14 mb-4 bg-primary-100 dark:bg-primary-900/30 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-1">Our Clients</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Trusted partners</p>
                    <div class="mt-4 flex items-center text-primary-500 text-sm font-medium">
                        View all
                        <svg class="w-4 h-4 ml-1 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </div>
            </a>

            <!-- Programs Card -->
            <a href="#ourCourses" class="group relative p-6 bg-white dark:bg-slate-800 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-green-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <div class="relative">
                    <div class="w-14 h-14 mb-4 bg-green-100 dark:bg-green-900/30 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-1">Programs</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Training courses</p>
                    <div class="mt-4 flex items-center text-green-500 text-sm font-medium">
                        Explore
                        <svg class="w-4 h-4 ml-1 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </div>
            </a>

            <!-- Gallery Card -->
            <a href="#ourGallery" class="group relative p-6 bg-white dark:bg-slate-800 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-purple-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <div class="relative">
                    <div class="w-14 h-14 mb-4 bg-purple-100 dark:bg-purple-900/30 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-1">Gallery</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Photo memories</p>
                    <div class="mt-4 flex items-center text-purple-500 text-sm font-medium">
                        View gallery
                        <svg class="w-4 h-4 ml-1 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </div>
            </a>

            <!-- Videos Card -->
            <a href="#ourVideos" class="group relative p-6 bg-white dark:bg-slate-800 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-red-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <div class="relative">
                    <div class="w-14 h-14 mb-4 bg-red-100 dark:bg-red-900/30 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-1">Videos</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Watch & learn</p>
                    <div class="mt-4 flex items-center text-red-500 text-sm font-medium">
                        Watch now
                        <svg class="w-4 h-4 ml-1 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </div>
            </a>
        </div>
    </div>
</section>
