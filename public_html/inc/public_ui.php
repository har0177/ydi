<?php
/**
 * Public Site UI Helper Functions - DRY Approach
 * Reusable components for frontend pages
 */

// Decode HTML entities safely
function safeHtml($str) {
    return htmlspecialchars(html_entity_decode($str, ENT_QUOTES, 'UTF-8'));
}

// Page title section with breadcrumb
function pageTitle($title, $breadcrumbs = [], $subtitle = '') {
    echo '<section class="page-title-section">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="text-center">
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-4">' . htmlspecialchars($title) . '</h1>';
    if ($subtitle) {
        echo '<p class="text-white/80 text-lg">' . htmlspecialchars($subtitle) . '</p>';
    }
    if (!empty($breadcrumbs)) {
        echo '<nav class="flex justify-center mt-4">
                <ol class="flex items-center space-x-2 text-white/80">
                    <li><a href="index.php" class="hover:text-white transition-colors">Home</a></li>';
        foreach ($breadcrumbs as $item) {
            echo '<li><span class="mx-2">/</span></li>';
            if (isset($item['url'])) {
                echo '<li><a href="' . htmlspecialchars($item['url']) . '" class="hover:text-white transition-colors">' . htmlspecialchars($item['label']) . '</a></li>';
            } else {
                echo '<li class="text-white">' . htmlspecialchars($item['label']) . '</li>';
            }
        }
        echo '</ol></nav>';
    }
    echo '</div></div></section>';
}

// Section header with badge, title, and description
function sectionHeader($badge, $badgeColor, $title, $highlight, $description) {
    echo '<div class="text-center max-w-2xl mx-auto mb-16">
        <span class="inline-block px-4 py-1.5 bg-' . $badgeColor . '-100 dark:bg-' . $badgeColor . '-900/30 text-' . $badgeColor . '-600 dark:text-' . $badgeColor . '-400 text-sm font-semibold rounded-full mb-4">' . htmlspecialchars($badge) . '</span>
        <h2 class="font-display text-3xl md:text-4xl lg:text-5xl font-bold text-slate-800 dark:text-white mb-4">
            ' . htmlspecialchars($title) . ' <span class="gradient-text">' . htmlspecialchars($highlight) . '</span>
        </h2>
        <p class="text-slate-600 dark:text-slate-400">' . htmlspecialchars($description) . '</p>
    </div>';
}

// Section header (compact version for inner pages)
function sectionHeaderCompact($badge, $badgeColor, $title, $highlight, $description) {
    echo '<div class="text-center max-w-2xl mx-auto mb-12">
        <span class="inline-block px-4 py-1.5 bg-' . $badgeColor . '-100 dark:bg-' . $badgeColor . '-900/30 text-' . $badgeColor . '-600 dark:text-' . $badgeColor . '-400 text-sm font-semibold rounded-full mb-4">' . htmlspecialchars($badge) . '</span>
        <h2 class="font-display text-3xl md:text-4xl font-bold text-slate-800 dark:text-white mb-4">
            ' . htmlspecialchars($title) . ' <span class="gradient-text">' . htmlspecialchars($highlight) . '</span>
        </h2>
        <p class="text-slate-600 dark:text-slate-400">' . htmlspecialchars($description) . '</p>
    </div>';
}

// Truncate text with ellipsis
function truncateText($text, $length = 100) {
    $text = strip_tags($text);
    if (strlen($text) <= $length) return $text;
    return preg_replace('/\s\S*$/', '', substr($text, 0, $length)) . '...';
}

// Get data from database as array
function fetchAll($table, $orderBy = 'id ASC', $limit = null, $where = '') {
    $db = new database();
    $sql = "SELECT * FROM $table";
    if ($where) $sql .= " WHERE $where";
    $sql .= " ORDER BY $orderBy";
    if ($limit) $sql .= " LIMIT $limit";
    $db->query($sql);
    $results = [];
    while ($r = $db->fetchObject()) {
        $results[] = $r;
    }
    return $results;
}

// Empty state message
function emptyState($message = 'No items found.') {
    echo '<div class="text-center py-12">
        <p class="text-slate-500 dark:text-slate-400">' . htmlspecialchars($message) . '</p>
    </div>';
}

// CTA Section
function ctaSection($title, $description, $buttonText, $buttonUrl) {
    echo '<section class="py-16 bg-gradient-to-r from-primary-500 to-secondary-500">
        <div class="container mx-auto px-4 lg:px-8 text-center">
            <h2 class="text-3xl font-bold text-white mb-4">' . htmlspecialchars($title) . '</h2>
            <p class="text-white/80 mb-8 max-w-2xl mx-auto">' . htmlspecialchars($description) . '</p>
            <a href="' . htmlspecialchars($buttonUrl) . '" class="inline-flex items-center gap-2 px-8 py-4 bg-white text-primary-600 font-semibold rounded-full shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                ' . htmlspecialchars($buttonText) . '
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </section>';
}
