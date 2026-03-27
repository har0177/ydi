<?php require 'header.php'; ?>

<?php
$db = new database();
$title = "Page Not Found";
$body = "";
$page_id = "";
$found = false;

try {
    if (isset($_GET["id"]) && !empty($_GET["id"])) {
        $id = intval($_GET["id"]);
        $db->query("SELECT * FROM pages WHERE page_id = ?", array($id));
        if ($db->rowCount() > 0) {
            $r = $db->fetchObject();
            $title = html_entity_decode($r->page_title, ENT_QUOTES, 'UTF-8');
            $body = $r->page_body;
            $page_id = $r->page_id;
            $found = true;
        }
    } else {
        $db->query("SELECT * FROM pages WHERE page_id = 1");
        if ($db->rowCount() > 0) {
            $r = $db->fetchObject();
            $title = html_entity_decode($r->page_title, ENT_QUOTES, 'UTF-8');
            $body = $r->page_body;
            $page_id = $r->page_id;
            $found = true;
        }
    }
} catch (PDOException $e) {
    // Handle error silently
}
?>

<!-- Page Title Section -->
<section class="page-title-section">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="text-center">
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-4"><?php echo htmlspecialchars($title); ?></h1>
            <nav class="flex justify-center">
                <ol class="flex items-center space-x-2 text-white/80">
                    <li><a href="index.php" class="hover:text-white transition-colors">Home</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li class="text-white"><?php echo htmlspecialchars($title); ?></li>
                </ol>
            </nav>
        </div>
    </div>
</section>

<!-- Page Content -->
<section class="py-16 bg-white dark:bg-slate-900">
    <div class="container mx-auto px-4 lg:px-8">
        <?php if ($found): ?>
        <div class="max-w-4xl mx-auto">
            <!-- Content Card -->
            <div class="bg-slate-50 dark:bg-slate-800 rounded-3xl p-8 lg:p-12 shadow-sm">
                <h2 class="text-2xl md:text-3xl font-bold text-slate-800 dark:text-white mb-6 flex items-center gap-3">
                    <span class="w-2 h-8 bg-gradient-to-b from-primary-500 to-secondary-500 rounded-full"></span>
                    <?php echo htmlspecialchars($title); ?>
                </h2>

                <div class="prose prose-lg dark:prose-invert max-w-none text-slate-600 dark:text-slate-400 leading-relaxed">
                    <?php echo $body; ?>
                </div>
            </div>

            <!-- Back Button -->
            <div class="mt-8 text-center">
                <a href="index.php" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-primary-500 to-secondary-500 text-white font-semibold rounded-full shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300">
                    <svg class="w-5 h-5 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                    Back to Home
                </a>
            </div>
        </div>
        <?php else: ?>
        <!-- 404 Not Found -->
        <div class="max-w-md mx-auto text-center">
            <div class="w-24 h-24 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-slate-800 dark:text-white mb-4">Page Not Found</h2>
            <p class="text-slate-600 dark:text-slate-400 mb-8">The page you're looking for doesn't exist or has been removed.</p>
            <a href="index.php" class="inline-flex items-center gap-2 px-6 py-3 bg-primary-500 text-white font-medium rounded-full hover:bg-primary-600 transition-colors">
                <svg class="w-5 h-5 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
                Go to Home
            </a>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php require 'footer.php'; ?>
