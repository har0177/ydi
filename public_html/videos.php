<?php require 'header.php'; ?>

<?php
if (isset($_GET["id"]) && !empty($_GET["id"])) {
    $id = intval($_GET["id"]);
    $db = new database();
    try {
        $db->query("SELECT * FROM videos WHERE id = ?", array($id));

        if ($db->rowCount() > 0) {
            $r = $db->fetchObject();
?>

<!-- Page Title Section -->
<section class="page-title-section">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="text-center">
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-4"><?php echo htmlspecialchars(html_entity_decode($r->name ?? 'Video', ENT_QUOTES, 'UTF-8')); ?></h1>
            <nav class="flex justify-center">
                <ol class="flex items-center space-x-2 text-white/80">
                    <li><a href="index.php" class="hover:text-white transition-colors">Home</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li><a href="index.php#ourVideos" class="hover:text-white transition-colors">Videos</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li class="text-white"><?php echo htmlspecialchars(html_entity_decode($r->name ?? 'Video', ENT_QUOTES, 'UTF-8')); ?></li>
                </ol>
            </nav>
        </div>
    </div>
</section>

<!-- Video Content -->
<section class="py-16 bg-white dark:bg-slate-900">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <!-- Video Player -->
            <div class="aspect-video rounded-2xl overflow-hidden shadow-2xl bg-slate-900">
                <iframe
                    src="https://www.youtube.com/embed/<?php echo htmlspecialchars($r->link); ?>?rel=0&autoplay=0"
                    class="w-full h-full"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen
                ></iframe>
            </div>

            <!-- Video Info -->
            <div class="mt-8">
                <h2 class="text-2xl font-bold text-slate-800 dark:text-white mb-4">
                    <?php echo htmlspecialchars(html_entity_decode($r->name ?? '', ENT_QUOTES, 'UTF-8')); ?>
                </h2>
                <?php if (!empty($r->descr)) { ?>
                <div class="text-slate-600 dark:text-slate-400 leading-relaxed">
                    <?php echo $r->descr; ?>
                </div>
                <?php } ?>
            </div>

            <!-- Back Button -->
            <div class="mt-12 pt-8 border-t border-slate-200 dark:border-slate-700">
                <a href="index.php#ourVideos" class="inline-flex items-center gap-2 text-primary-500 hover:text-primary-600 font-medium transition-colors">
                    <svg class="w-5 h-5 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                    Back to All Videos
                </a>
            </div>
        </div>
    </div>
</section>

<?php
        } else {
?>
<!-- Not Found -->
<section class="page-title-section">
    <div class="container mx-auto px-4 lg:px-8 text-center">
        <h1 class="text-3xl md:text-4xl font-bold text-white">Video Not Found</h1>
    </div>
</section>
<section class="py-20 bg-white dark:bg-slate-900">
    <div class="container mx-auto px-4 lg:px-8 text-center">
        <div class="max-w-md mx-auto">
            <div class="w-24 h-24 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-slate-800 dark:text-white mb-4">Video Not Found</h2>
            <p class="text-slate-600 dark:text-slate-400 mb-8">The video you're looking for doesn't exist or has been removed.</p>
            <a href="index.php#ourVideos" class="inline-flex items-center gap-2 px-6 py-3 bg-primary-500 text-white font-medium rounded-full hover:bg-primary-600 transition-colors">
                <svg class="w-5 h-5 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
                Back to Videos
            </a>
        </div>
    </div>
</section>
<?php
        }
    } catch (PDOException $e) {
        echo '<div class="container mx-auto px-4 py-20 text-center"><p class="text-red-500">Error loading video.</p></div>';
    }
} else {
?>
<!-- All Videos -->
<section class="page-title-section">
    <div class="container mx-auto px-4 lg:px-8 text-center">
        <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-4">Our Videos</h1>
        <p class="text-white/80 text-lg">Watch and learn from our educational content</p>
    </div>
</section>

<section class="py-16 bg-white dark:bg-slate-900">
    <div class="container mx-auto px-4 lg:px-8">
        <?php
        $videos = new database();
        $videos->query("SELECT * FROM videos WHERE status = 1 ORDER BY v_order ASC");

        if ($videos->rowCount() > 0) {
        ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <?php while ($vid = $videos->fetchObject()) { ?>
            <div class="group relative bg-white dark:bg-slate-800 rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 card-hover">
                <div class="relative aspect-video">
                    <img src="https://img.youtube.com/vi/<?php echo htmlspecialchars($vid->link); ?>/hqdefault.jpg" alt="Video thumbnail" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent flex items-center justify-center">
                        <a href="https://www.youtube.com/watch?v=<?php echo htmlspecialchars($vid->link); ?>" data-fancybox="videos" class="w-16 h-16 bg-red-500 rounded-full flex items-center justify-center transform group-hover:scale-110 transition-transform shadow-lg">
                            <svg class="w-6 h-6 text-white ml-1" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8 5v14l11-7z"/>
                            </svg>
                        </a>
                    </div>
                </div>
                <?php if (!empty($vid->name)) { ?>
                <div class="p-4">
                    <h4 class="font-semibold text-slate-800 dark:text-white line-clamp-2"><?php echo htmlspecialchars(html_entity_decode($vid->name ?? '', ENT_QUOTES, 'UTF-8')); ?></h4>
                </div>
                <?php } ?>
            </div>
            <?php } ?>
        </div>
        <?php } else { ?>
        <div class="text-center py-12">
            <p class="text-slate-500 dark:text-slate-400">No videos found.</p>
        </div>
        <?php } ?>
    </div>
</section>
<?php } ?>

<?php require 'footer.php'; ?>
