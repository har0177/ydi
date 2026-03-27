<?php include("header.php"); ?>
<?php include("banner.php"); ?>

<!-- Main Content -->
<main>

<?php
$features = fetchAll('features', 'feature_id ASC');
if (count($features) > 0) {
?>
<!-- Features Section -->
<section class="py-20 bg-white dark:bg-slate-900">
    <div class="container mx-auto px-4 lg:px-8">
        <?php sectionHeader('What We Offer', 'primary', 'Our', 'Features', 'Discover the unique aspects that make YDI a premier institution for youth development.'); ?>

        <!-- Features Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            <?php
            $icons = [
                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>',
                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>',
                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>',
                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>',
                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>',
                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>'
            ];
            $colors = ['primary', 'green', 'purple', 'blue', 'pink', 'amber'];

            foreach ($features as $index => $f) {
                $color = $colors[$index % count($colors)];
                $icon = $icons[$index % count($icons)];
            ?>
            <div class="group relative p-8 bg-slate-50 dark:bg-slate-800/50 rounded-2xl hover:bg-white dark:hover:bg-slate-800 shadow-sm hover:shadow-xl transition-all duration-300 card-hover border-2 border-transparent hover:border-primary-500/20">
                <div class="flex items-start gap-5">
                    <div class="flex-shrink-0 w-14 h-14 bg-<?php echo $color; ?>-100 dark:bg-<?php echo $color; ?>-900/30 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7 text-<?php echo $color; ?>-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><?php echo $icon; ?></svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-2 group-hover:text-primary-500 transition-colors">
                            <?php echo safeHtml($f->feature_title); ?>
                        </h3>
                        <p class="text-slate-600 dark:text-slate-400 leading-relaxed">
                            <?php echo safeHtml(cleanString($f->feature_body)); ?>
                        </p>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</section>
<?php } ?>

<?php
$clientsList = fetchAll('clients', 'c_order ASC');
if (count($clientsList) > 0) {
?>
<!-- Clients Section -->
<section class="py-20 bg-white dark:bg-slate-900" id="ourClients">
    <div class="container mx-auto px-4 lg:px-8">
        <?php sectionHeader('Trusted By', 'primary', 'Our', 'Clients', 'Organizations that trust YDI for their training and development needs.'); ?>

        <!-- Clients Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-8">
            <?php foreach ($clientsList as $cl) { ?>
            <div class="group text-center">
                <div class="relative mb-4 mx-auto w-28 h-28 lg:w-32 lg:h-32">
                    <div class="absolute inset-0 rounded-full bg-gradient-to-r from-primary-500 to-secondary-500 p-1 transform group-hover:scale-105 transition-transform duration-300">
                        <div class="w-full h-full rounded-full overflow-hidden bg-white flex items-center justify-center p-3">
                            <img loading="lazy" decoding="async" src="<?php echo htmlspecialchars($cl->image); ?>" alt="<?php echo safeHtml($cl->title); ?>" class="max-w-full max-h-full object-contain">
                        </div>
                    </div>
                </div>
                <h4 class="font-semibold text-slate-800 dark:text-white group-hover:text-primary-500 transition-colors text-sm lg:text-base">
                    <?php echo safeHtml($cl->title); ?>
                </h4>
            </div>
            <?php } ?>
        </div>
    </div>
</section>
<?php } ?>

<?php
$galleryItems = fetchAll('gallery', 'g_order ASC', 8);
if (count($galleryItems) > 0) {
?>
<!-- Gallery Section -->
<section class="py-20 bg-white dark:bg-slate-900" id="ourGallery">
    <div class="container mx-auto px-4 lg:px-8">
        <?php sectionHeader('Memories', 'purple', 'Our', 'Gallery', 'Capturing moments of learning, growth, and achievement.'); ?>

        <!-- Gallery Grid -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 lg:gap-6">
            <?php foreach ($galleryItems as $index => $image) {
                $source = explode("|", $image->images);
                $mainImage = $source[0];
                $imageExists = file_exists($mainImage);
                $photoCount = count($source);
                $decodedTitle = safeHtml($image->title);
            ?>
            <div class="group relative overflow-hidden rounded-2xl <?php echo ($index === 0) ? 'md:col-span-2 md:row-span-2' : ''; ?>">
                <?php if ($photoCount === 1) { ?>
                <a href="<?php echo htmlspecialchars($mainImage); ?>" data-fancybox="gallery-home" data-caption="<?php echo $decodedTitle; ?>" class="block aspect-square bg-slate-100 dark:bg-slate-800">
                <?php } else { ?>
                <a href="gallery.php?id=<?php echo (int)$image->id; ?>" class="block aspect-square bg-slate-100 dark:bg-slate-800">
                <?php } ?>
                    <?php if ($imageExists) { ?>
                    <img loading="lazy" decoding="async" src="<?php echo htmlspecialchars($mainImage); ?>" alt="<?php echo $decodedTitle; ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <?php } else { ?>
                    <div class="w-full h-full flex flex-col items-center justify-center text-slate-400 dark:text-slate-500">
                        <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="text-xs px-2 text-center"><?php echo $decodedTitle; ?></span>
                    </div>
                    <?php } ?>
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-slate-900/20 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300 flex flex-col justify-end p-4">
                        <h4 class="text-white font-semibold transform translate-y-4 group-hover:translate-y-0 transition-transform"><?php echo $decodedTitle; ?></h4>
                        <?php if ($photoCount > 1) { ?>
                        <div class="flex items-center gap-2 mt-2 transform translate-y-4 group-hover:translate-y-0 transition-transform" style="transition-delay: 50ms;">
                            <span class="text-primary-400 text-sm"><?php echo $photoCount; ?> Photos</span>
                            <svg class="w-4 h-4 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </div>
                        <?php } ?>
                    </div>
                </a>
            </div>
            <?php } ?>
        </div>

        <div class="text-center mt-12">
            <a href="gallery.php" class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-purple-500 to-pink-500 text-white font-semibold rounded-full shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                View All Photos
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </div>
</section>
<?php } ?>

<?php
$videosList = fetchAll('videos', 'v_order ASC', null, 'status = 1');
if (count($videosList) > 0) {
$videosPerPage = 8;
$totalVideos = count($videosList);
$totalPages = ceil($totalVideos / $videosPerPage);
?>
<!-- Videos Section -->
<section class="py-20 bg-slate-50 dark:bg-slate-800" id="ourVideos">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="flex items-end justify-between mb-12">
            <div class="flex-1">
                <?php sectionHeader('Watch & Learn', 'red', 'Our', 'Videos', 'Educational content and highlights from our programs.'); ?>
            </div>
            <?php if ($totalPages > 1) { ?>
            <div class="flex items-center gap-3 mb-1" x-data>
                <button @click="$dispatch('videos-prev')" class="w-12 h-12 rounded-full border-2 border-slate-300 dark:border-slate-600 hover:border-red-500 hover:bg-red-500 hover:text-white text-slate-500 dark:text-slate-400 flex items-center justify-center transition-all duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                <button @click="$dispatch('videos-next')" class="w-12 h-12 rounded-full border-2 border-slate-300 dark:border-slate-600 hover:border-red-500 hover:bg-red-500 hover:text-white text-slate-500 dark:text-slate-400 flex items-center justify-center transition-all duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>
            <?php } ?>
        </div>

        <!-- Videos Slider -->
        <div x-data="{
            currentPage: 0,
            totalPages: <?php echo $totalPages; ?>,
            next() { this.currentPage = (this.currentPage + 1) % this.totalPages },
            prev() { this.currentPage = (this.currentPage - 1 + this.totalPages) % this.totalPages }
        }"
        @videos-next.window="next()"
        @videos-prev.window="prev()"
        class="relative overflow-hidden">
            <div class="flex transition-transform duration-500 ease-in-out" :style="'transform: translateX(-' + (currentPage * 100) + '%)'">
                <?php for ($page = 0; $page < $totalPages; $page++) { ?>
                <div class="w-full flex-shrink-0">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        <?php
                        $pageVideos = array_slice($videosList, $page * $videosPerPage, $videosPerPage);
                        foreach ($pageVideos as $vid) { ?>
                        <div class="group relative bg-white dark:bg-slate-700 rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 card-hover">
                            <div class="relative aspect-video">
                                <img loading="lazy" decoding="async" src="https://img.youtube.com/vi/<?php echo htmlspecialchars($vid->link); ?>/hqdefault.jpg" alt="Video thumbnail" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent flex items-center justify-center">
                                    <a href="https://www.youtube.com/watch?v=<?php echo htmlspecialchars($vid->link); ?>" data-fancybox="videos" class="w-16 h-16 bg-red-500 rounded-full flex items-center justify-center transform group-hover:scale-110 transition-transform shadow-lg">
                                        <svg class="w-6 h-6 text-white ml-1" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M8 5v14l11-7z"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                            <div class="p-4">
                                <div class="flex items-center gap-2 text-red-500 text-sm font-medium">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/>
                                    </svg>
                                    YouTube
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <?php } ?>
            </div>

            <?php if ($totalPages > 1) { ?>
            <!-- Page Dots -->
            <div class="flex justify-center gap-2 mt-8">
                <?php for ($i = 0; $i < $totalPages; $i++) { ?>
                <button @click="currentPage = <?php echo $i; ?>" :class="currentPage === <?php echo $i; ?> ? 'w-8 bg-red-500' : 'w-3 bg-slate-300 dark:bg-slate-600 hover:bg-red-300'" class="h-3 rounded-full transition-all duration-300"></button>
                <?php } ?>
            </div>
            <?php } ?>
        </div>
    </div>
</section>
<?php } ?>

<!-- CTA Section -->
<section class="relative py-24 overflow-hidden">
    <div class="absolute inset-0">
        <img loading="lazy" decoding="async" src="content/img/home/promotion-1.jpg" alt="Background" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-primary-600/90 to-secondary-600/90"></div>
    </div>
    <div class="absolute top-10 left-10 w-32 h-32 border border-white/20 rounded-full animate-float hidden lg:block"></div>
    <div class="absolute bottom-10 right-10 w-48 h-48 border border-white/20 rounded-full animate-float hidden lg:block" style="animation-delay: 2s;"></div>

    <div class="relative z-10 container mx-auto px-4 lg:px-8 text-center">
        <h2 class="font-display text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-6">Need More Information?</h2>
        <p class="text-xl text-white/80 max-w-2xl mx-auto mb-10">Welcome to the World of YDI, where everyone learns and grows together.</p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="contact.php" class="group inline-flex items-center gap-2 px-8 py-4 bg-white text-primary-600 font-semibold rounded-full shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
                Contact Us
                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
            <a href="tel:+92946725501" class="inline-flex items-center gap-2 px-8 py-4 bg-white/10 backdrop-blur-sm text-white font-semibold rounded-full border border-white/20 hover:bg-white/20 hover:-translate-y-1 transition-all duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
                +92-946-725501
            </a>
        </div>
    </div>
</section>

<?php
$programsList = fetchAll('programs', 'p_id ASC');
if (count($programsList) > 0) {
?>
<!-- Programs Section -->
<section class="py-20 bg-white dark:bg-slate-900" id="ourCourses">
    <div class="container mx-auto px-4 lg:px-8">
        <?php sectionHeader('Learn & Grow', 'green', 'Our', 'Programs', 'Comprehensive training programs designed to develop skills and empower youth.'); ?>

        <!-- Programs Grid -->
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
            <?php foreach ($programsList as $p) { ?>
            <div class="group relative bg-white dark:bg-slate-800 rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 card-hover">
                <div class="relative aspect-[4/3] overflow-hidden">
                    <img loading="lazy" decoding="async" src="<?php echo htmlspecialchars($p->image); ?>" alt="<?php echo safeHtml($p->p_title); ?>" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-slate-900/20 to-transparent"></div>
                    <div class="absolute top-4 left-4">
                        <span class="px-3 py-1 bg-primary-500 text-white text-xs font-semibold rounded-full">Program</span>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-2 group-hover:text-primary-500 transition-colors line-clamp-2">
                        <?php echo safeHtml($p->p_title); ?>
                    </h3>
                    <p class="text-slate-600 dark:text-slate-400 text-sm mb-4 line-clamp-3">
                        <?php echo truncateText($p->p_body, 100); ?>
                    </p>
                    <a href="program.php?id=<?php echo (int)$p->p_id; ?>" class="inline-flex items-center gap-2 text-primary-500 font-medium text-sm group/link">
                        Learn More
                        <svg class="w-4 h-4 group-hover/link:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</section>
<?php } ?>

<?php
$teamList = fetchAll('team', 'team_order ASC', 5);
if (count($teamList) > 0) {
?>
<!-- Team Section -->
<section class="py-20 bg-gradient-to-br from-slate-100 to-white dark:from-slate-800 dark:to-slate-900" id="ourTeam">
    <div class="container mx-auto px-4 lg:px-8">
        <?php sectionHeader('Our Team', 'blue', 'Meet Our', 'People', 'Dedicated professionals committed to your success.'); ?>

        <!-- Team Grid -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6 lg:gap-8">
            <?php foreach ($teamList as $member) { ?>
            <div class="group text-center">
                <div class="relative mb-4 mx-auto w-32 h-32 lg:w-40 lg:h-40">
                    <div class="absolute inset-0 rounded-full bg-gradient-to-r from-primary-500 to-secondary-500 p-1 transform group-hover:scale-105 transition-transform duration-300">
                        <div class="w-full h-full rounded-full overflow-hidden bg-white dark:bg-slate-800">
                            <img loading="lazy" decoding="async" src="<?php echo htmlspecialchars($member->image); ?>" alt="<?php echo safeHtml($member->title); ?>" class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>
                <h4 class="font-bold text-slate-800 dark:text-white group-hover:text-primary-500 transition-colors">
                    <?php echo safeHtml($member->title); ?>
                </h4>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                    <?php echo safeHtml($member->desg); ?>
                </p>
            </div>
            <?php } ?>
        </div>

        <div class="text-center mt-12">
            <a href="team.php" class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-blue-500 to-purple-500 text-white font-semibold rounded-full shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                View All Team Members
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </div>
</section>
<?php } ?>

<?php
$alumniList = fetchAll('alumni', 'alumni_order ASC', 5);
if (count($alumniList) > 0) {
?>
<!-- Alumni Section -->
<section class="py-20 bg-white dark:bg-slate-900" id="ourAlumni">
    <div class="container mx-auto px-4 lg:px-8">
        <?php sectionHeader('Our Pride', 'green', 'Our', 'Alumni', 'Successful graduates making a difference in the world.'); ?>

        <!-- Alumni Grid -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6 lg:gap-8">
            <?php foreach ($alumniList as $alum) { ?>
            <div class="group text-center">
                <div class="relative mb-4 mx-auto w-32 h-32 lg:w-40 lg:h-40">
                    <div class="absolute inset-0 rounded-full bg-gradient-to-r from-green-500 to-emerald-500 p-1 transform group-hover:scale-105 transition-transform duration-300">
                        <div class="w-full h-full rounded-full overflow-hidden bg-white dark:bg-slate-800">
                            <img loading="lazy" decoding="async" src="<?php echo htmlspecialchars($alum->image); ?>" alt="<?php echo safeHtml($alum->title); ?>" class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>
                <h4 class="font-bold text-slate-800 dark:text-white group-hover:text-green-500 transition-colors">
                    <?php echo safeHtml($alum->title); ?>
                </h4>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                    <?php echo safeHtml($alum->desg); ?>
                </p>
            </div>
            <?php } ?>
        </div>

        <div class="text-center mt-12">
            <a href="alumni-all.php" class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-green-500 to-emerald-500 text-white font-semibold rounded-full shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                View All Alumni
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </div>
</section>
<?php } ?>

<!-- Stats Section -->
<section class="py-20 bg-gradient-to-r from-primary-500 to-secondary-500 relative overflow-hidden" x-data="{ shown: false }" x-init="
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                shown = true;
            }
        });
    }, { threshold: 0.3 });
    observer.observe($el);
">
    <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.4\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>

    <div class="container mx-auto px-4 lg:px-8 relative z-10">
        <div class="text-center mb-12">
            <h2 class="font-display text-3xl md:text-4xl font-bold text-white mb-2">Some Fun Facts</h2>
            <p class="text-white/80">YDI facts & figures</p>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-8">
            <?php
            $stats = [
                ['icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', 'count' => 300, 'label' => 'Events Held'],
                ['icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z', 'count' => 10000, 'label' => 'Students Trained'],
                ['icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z', 'count' => 500, 'label' => 'Happy Clients'],
                ['icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'count' => 5000, 'label' => 'Hours Support']
            ];
            foreach ($stats as $stat) { ?>
            <div class="text-center">
                <div class="w-24 h-24 lg:w-32 lg:h-32 mx-auto bg-white/10 rounded-full flex items-center justify-center backdrop-blur-sm mb-4">
                    <svg class="w-10 h-10 lg:w-12 lg:h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo $stat['icon']; ?>"/>
                    </svg>
                </div>
                <div class="text-4xl lg:text-5xl font-bold text-white mb-2" x-data="{ count: 0 }" x-effect="if(shown) { let target = <?php echo $stat['count']; ?>; let interval = setInterval(() => { if(count < target) count += Math.ceil(target/30); else { count = target; clearInterval(interval); } }, 50); }" x-text="count + '+'">0</div>
                <div class="text-white/80 font-medium"><?php echo $stat['label']; ?></div>
            </div>
            <?php } ?>
        </div>
    </div>
</section>

</main>

<?php include("footer.php"); ?>
