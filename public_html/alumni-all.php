<?php require 'header.php'; ?>

<?php
$alumniList = fetchAll('alumni', 'alumni_order ASC');
pageTitle('Our Alumni', [['label' => 'Alumni']]);
?>

<!-- Alumni Section -->
<section class="py-16 bg-white dark:bg-slate-900">
    <div class="container mx-auto px-4 lg:px-8">
        <?php sectionHeaderCompact('Our Alumni', 'green', 'Successful', 'Graduates', 'Meet our proud alumni making a difference in the world.'); ?>

        <?php if (count($alumniList) > 0) { ?>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-6 lg:gap-8">
            <?php foreach ($alumniList as $alum) { ?>
            <div class="group text-center">
                <div class="relative mb-4 mx-auto w-28 h-28 lg:w-36 lg:h-36">
                    <div class="absolute inset-0 rounded-full bg-gradient-to-r from-green-500 to-emerald-500 p-1 transform group-hover:scale-105 transition-transform duration-300">
                        <div class="w-full h-full rounded-full overflow-hidden bg-white dark:bg-slate-800">
                            <img src="<?php echo htmlspecialchars($alum->image); ?>" alt="<?php echo safeHtml($alum->title); ?>" class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>
                <h4 class="font-bold text-slate-800 dark:text-white group-hover:text-green-500 transition-colors text-sm lg:text-base">
                    <?php echo safeHtml($alum->title); ?>
                </h4>
                <p class="text-xs lg:text-sm text-slate-500 dark:text-slate-400 mt-1">
                    <?php echo safeHtml($alum->desg); ?>
                </p>
            </div>
            <?php } ?>
        </div>
        <?php } else { emptyState('No alumni found.'); } ?>
    </div>
</section>

<?php ctaSection("Are You a YDI Alumni?", "Stay connected with your alma mater and inspire the next generation.", "Contact Us", "contact.php"); ?>

<?php require 'footer.php'; ?>
