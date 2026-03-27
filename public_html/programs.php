<?php require 'header.php'; ?>

<?php
$programsList = fetchAll('programs', 'p_id ASC');
pageTitle('Our Programs', [['label' => 'Programs']]);
?>

<!-- Programs List -->
<section class="py-16 bg-white dark:bg-slate-900">
    <div class="container mx-auto px-4 lg:px-8">
        <?php sectionHeaderCompact('Learn & Grow', 'green', 'Training', 'Programs', 'Comprehensive training programs designed to develop skills and empower youth.'); ?>

        <?php if (count($programsList) > 0) { ?>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($programsList as $p) { ?>
            <div class="group relative bg-white dark:bg-slate-800 rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 card-hover">
                <div class="relative aspect-[4/3] overflow-hidden">
                    <img src="<?php echo htmlspecialchars($p->image); ?>" alt="<?php echo safeHtml($p->p_title); ?>" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-slate-900/20 to-transparent"></div>
                    <div class="absolute top-4 left-4">
                        <span class="px-3 py-1 bg-primary-500 text-white text-xs font-semibold rounded-full">Program</span>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-3 group-hover:text-primary-500 transition-colors line-clamp-2">
                        <?php echo safeHtml($p->p_title); ?>
                    </h3>
                    <p class="text-slate-600 dark:text-slate-400 text-sm mb-4 line-clamp-3">
                        <?php echo truncateText($p->p_body, 150); ?>
                    </p>
                    <a href="program.php?id=<?php echo (int)$p->p_id; ?>" class="inline-flex items-center gap-2 text-primary-500 font-medium group/link">
                        Learn More
                        <svg class="w-4 h-4 group-hover/link:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>
            </div>
            <?php } ?>
        </div>
        <?php } else { ?>
        <div class="text-center py-12">
            <div class="w-24 h-24 bg-slate-100 dark:bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-2">No Programs Available</h3>
            <p class="text-slate-600 dark:text-slate-400">Please check back later for our upcoming programs.</p>
        </div>
        <?php } ?>
    </div>
</section>

<?php ctaSection("Interested in Our Programs?", "Contact us to learn more about enrollment and upcoming sessions.", "Contact Us", "contact.php"); ?>

<?php require 'footer.php'; ?>
