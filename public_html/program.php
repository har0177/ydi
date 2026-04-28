<?php require 'header.php';

$db = new database();

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = intval($_GET['id']);
    $db->query("SELECT * FROM programs WHERE p_id = ?", array($id));

    if ($db->rowCount() > 0) {
        $program = $db->fetchObject();
        $title = safeHtml($program->p_title);

        pageTitle($title, [
            ['label' => 'Programs', 'url' => 'index.php#ourCourses'],
            ['label' => $title]
        ]);
?>

<!-- Program Content -->
<section class="py-16 bg-white dark:bg-slate-900">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="grid lg:grid-cols-3 gap-8 lg:gap-12">
            <!-- Program Image -->
            <div class="lg:col-span-1">
                <div class="sticky top-24">
                    <div class="rounded-2xl overflow-hidden shadow-xl">
                        <img src="<?php echo htmlspecialchars($program->image); ?>" alt="<?php echo $title; ?>" class="w-full h-auto">
                    </div>

                    <!-- Quick Info Card -->
                    <div class="mt-6 p-6 bg-slate-50 dark:bg-slate-800 rounded-2xl">
                        <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-4">Program Info</h3>
                        <ul class="space-y-3">
                            <li class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-primary-100 dark:bg-primary-900/30 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm text-slate-500 dark:text-slate-400">Category</p>
                                    <p class="font-medium text-slate-800 dark:text-white">Training Program</p>
                                </div>
                            </li>
                            <li class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-accent-100 dark:bg-accent-900/30 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-accent-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm text-slate-500 dark:text-slate-400">Target Audience</p>
                                    <p class="font-medium text-slate-800 dark:text-white">Youth & Students</p>
                                </div>
                            </li>
                        </ul>

                        <div class="mt-6">
                            <button
                                type="button"
                                data-service="<?php echo htmlspecialchars($program->p_title, ENT_QUOTES, 'UTF-8'); ?>"
                                @click="enquireService = $event.currentTarget.dataset.service; enquireOpen = true"
                                class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-primary-500 to-secondary-500 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                </svg>
                                Enquire Now
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Program Details -->
            <div class="lg:col-span-2">
                <div class="prose prose-lg dark:prose-invert max-w-none">
                    <h2 class="text-2xl font-bold text-slate-800 dark:text-white mb-6 flex items-center gap-3">
                        <span class="w-2 h-8 bg-gradient-to-b from-primary-500 to-secondary-500 rounded-full"></span>
                        About This Program
                    </h2>
                    <div class="text-slate-600 dark:text-slate-400 leading-relaxed">
                        <?php echo $program->p_body; ?>
                    </div>
                </div>

                <div class="mt-12 pt-8 border-t border-slate-200 dark:border-slate-700">
                    <a href="index.php#ourCourses" class="inline-flex items-center gap-2 text-primary-500 hover:text-primary-600 font-medium transition-colors">
                        <svg class="w-5 h-5 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                        Back to All Programs
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
    } else {
        pageTitle('Program Not Found', [['label' => 'Programs', 'url' => 'index.php#ourCourses'], ['label' => 'Not Found']]);
?>
<section class="py-20 bg-white dark:bg-slate-900">
    <div class="container mx-auto px-4 lg:px-8 text-center">
        <div class="max-w-md mx-auto">
            <div class="w-24 h-24 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-slate-800 dark:text-white mb-4">Program Not Found</h2>
            <p class="text-slate-600 dark:text-slate-400 mb-8">The program you're looking for doesn't exist or has been removed.</p>
            <a href="index.php#ourCourses" class="inline-flex items-center gap-2 px-6 py-3 bg-primary-500 text-white font-medium rounded-full hover:bg-primary-600 transition-colors">
                <svg class="w-5 h-5 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
                View All Programs
            </a>
        </div>
    </div>
</section>
<?php
    }
} else {
    pageTitle('Invalid Request', [['label' => 'Programs']]);
?>
<section class="py-20 bg-white dark:bg-slate-900">
    <div class="container mx-auto px-4 lg:px-8 text-center">
        <p class="text-slate-600 dark:text-slate-400 mb-8">Please select a valid program.</p>
        <a href="index.php#ourCourses" class="inline-flex items-center gap-2 px-6 py-3 bg-primary-500 text-white font-medium rounded-full hover:bg-primary-600 transition-colors">
            View All Programs
        </a>
    </div>
</section>
<?php } ?>

<?php require 'footer.php'; ?>
