<?php require 'header.php'; ?>

<?php
$db = new database();

if (isset($_GET["id"]) && !empty($_GET["id"])) {
    $id = intval($_GET["id"]);

    try {
        $db->query("SELECT * FROM gallery WHERE id = ?", array($id));

        if ($db->rowCount() > 0) {
            $image = $db->fetchObject();
            $source = explode("|", $image->images);
            $title = safeHtml($image->title);

            pageTitle($title, [
                ['label' => 'Gallery', 'url' => 'index.php#ourGallery'],
                ['label' => $title]
            ]);
?>

<!-- Gallery Content -->
<section class="py-16 bg-white dark:bg-slate-900">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 lg:gap-6">
            <?php foreach ($source as $img) { ?>
            <div class="group relative overflow-hidden rounded-2xl img-zoom aspect-square">
                <a href="<?php echo htmlspecialchars($img); ?>" data-fancybox="gallery" data-caption="<?php echo $title; ?>">
                    <img src="<?php echo htmlspecialchars($img); ?>" alt="<?php echo $title; ?>" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-slate-900/20 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-center justify-center">
                        <div class="w-14 h-14 bg-primary-500 rounded-full flex items-center justify-center transform scale-0 group-hover:scale-100 transition-transform duration-300">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                            </svg>
                        </div>
                    </div>
                </a>
            </div>
            <?php } ?>
        </div>

        <div class="text-center mt-12">
            <a href="index.php#ourGallery" class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-primary-500 to-secondary-500 text-white font-semibold rounded-full shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <svg class="w-5 h-5 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
                Back to Gallery
            </a>
        </div>
    </div>
</section>

<?php
        } else {
            pageTitle('Gallery Not Found', [['label' => 'Gallery', 'url' => 'index.php#ourGallery'], ['label' => 'Not Found']]);
?>
<section class="py-20 bg-white dark:bg-slate-900">
    <div class="container mx-auto px-4 lg:px-8 text-center">
        <div class="max-w-md mx-auto">
            <div class="w-24 h-24 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-slate-800 dark:text-white mb-4">Gallery Not Found</h2>
            <p class="text-slate-600 dark:text-slate-400 mb-8">The gallery you're looking for doesn't exist or has been removed.</p>
            <a href="index.php#ourGallery" class="inline-flex items-center gap-2 px-6 py-3 bg-primary-500 text-white font-medium rounded-full hover:bg-primary-600 transition-colors">
                <svg class="w-5 h-5 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
                Back to Gallery
            </a>
        </div>
    </div>
</section>
<?php
        }
    } catch (PDOException $e) {
        echo '<div class="container mx-auto px-4 py-20 text-center"><p class="text-red-500">Error loading gallery.</p></div>';
    }
} else {
    // All Galleries
    $galleryList = fetchAll('gallery', 'g_order ASC');
    pageTitle('Our Gallery', [], 'Capturing moments of learning, growth, and achievement');
?>

<section class="py-16 bg-white dark:bg-slate-900">
    <div class="container mx-auto px-4 lg:px-8">
        <?php if (count($galleryList) > 0) { ?>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 lg:gap-6">
            <?php foreach ($galleryList as $gal) {
                $images = explode("|", $gal->images);
                $firstImage = $images[0];
                $title = safeHtml($gal->title);
            ?>
            <div class="group relative overflow-hidden rounded-2xl img-zoom aspect-square">
                <a href="gallery.php?id=<?php echo (int)$gal->id; ?>">
                    <img src="<?php echo htmlspecialchars($firstImage); ?>" alt="<?php echo $title; ?>" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-slate-900/20 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300 flex flex-col justify-end p-4">
                        <h4 class="text-white font-semibold transform translate-y-4 group-hover:translate-y-0 transition-transform"><?php echo $title; ?></h4>
                        <div class="flex items-center gap-2 mt-2 transform translate-y-4 group-hover:translate-y-0 transition-transform" style="transition-delay: 50ms;">
                            <span class="text-primary-400 text-sm"><?php echo count($images); ?> Photos</span>
                        </div>
                    </div>
                </a>
            </div>
            <?php } ?>
        </div>
        <?php } else { emptyState('No galleries found.'); } ?>
    </div>
</section>
<?php } ?>

<?php require 'footer.php'; ?>
