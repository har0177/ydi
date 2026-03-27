<?php require 'header.php'; ?>

<?php
$teamList = fetchAll('team', 'team_order ASC');
pageTitle('Meet Our People', [['label' => 'Our Team']]);
?>

<!-- Team Section -->
<section class="py-16 bg-white dark:bg-slate-900">
    <div class="container mx-auto px-4 lg:px-8">
        <?php sectionHeaderCompact('Our Team', 'blue', 'Dedicated', 'Professionals', 'Meet the talented individuals committed to your success.'); ?>

        <?php if (count($teamList) > 0) { ?>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-6 lg:gap-8">
            <?php foreach ($teamList as $member) { ?>
            <div class="group text-center">
                <div class="relative mb-4 mx-auto w-28 h-28 lg:w-36 lg:h-36">
                    <div class="absolute inset-0 rounded-full bg-gradient-to-r from-primary-500 to-secondary-500 p-1 transform group-hover:scale-105 transition-transform duration-300">
                        <div class="w-full h-full rounded-full overflow-hidden bg-white dark:bg-slate-800">
                            <img src="<?php echo htmlspecialchars($member->image); ?>" alt="<?php echo safeHtml($member->title); ?>" class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>
                <h4 class="font-bold text-slate-800 dark:text-white group-hover:text-primary-500 transition-colors text-sm lg:text-base">
                    <?php echo safeHtml($member->title); ?>
                </h4>
                <p class="text-xs lg:text-sm text-slate-500 dark:text-slate-400 mt-1">
                    <?php echo safeHtml($member->desg); ?>
                </p>
            </div>
            <?php } ?>
        </div>
        <?php } else { emptyState('No team members found.'); } ?>
    </div>
</section>

<?php ctaSection("Want to Join Our Team?", "We're always looking for talented individuals to join our growing team.", "Contact Us", "contact.php"); ?>

<?php require 'footer.php'; ?>
