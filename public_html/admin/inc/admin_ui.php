<?php
/**
 * Admin UI Helper Functions - DRY Approach
 * Reusable components for all admin pages
 */

// Page header with gradient background
function adminHeader($title, $icon = '', $actionUrl = '', $actionText = '', $actionIcon = '+') {
    $iconSvg = getIcon($icon);
    $actionBtn = '';
    if ($actionUrl && $actionText) {
        $actionBtn = '<a href="' . htmlspecialchars($actionUrl) . '" class="inline-flex items-center gap-2 px-4 py-2 bg-white text-primary-500 rounded-lg font-medium hover:bg-primary-50 transition-colors text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            ' . htmlspecialchars($actionText) . '
        </a>';
    }
    echo '<div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden transition-colors">
        <div class="px-6 py-4 bg-gradient-to-r from-primary-500 to-secondary-400 flex items-center justify-between">
            <h2 class="text-lg font-semibold text-white flex items-center gap-2">' . $iconSvg . htmlspecialchars($title) . '</h2>
            ' . $actionBtn . '
        </div>
        <div class="p-6">';
}

// Page header for forms (add/edit) with back button
function adminFormHeader($title, $icon = '', $backUrl = '') {
    $iconSvg = getIcon($icon);
    echo '<div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden transition-colors">
        <div class="px-6 py-4 bg-gradient-to-r from-primary-500 to-secondary-400 flex items-center justify-between">
            <h2 class="text-lg font-semibold text-white flex items-center gap-2">' . $iconSvg . htmlspecialchars($title) . '</h2>
            <a href="' . htmlspecialchars($backUrl) . '" class="inline-flex items-center gap-2 px-4 py-2 bg-white/20 hover:bg-white/30 text-white rounded-lg transition-colors text-sm font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Back
            </a>
        </div>
        <div class="p-6">';
}

function adminFooter() {
    echo '</div></div>';
}

// Alert messages
function adminAlert($type, $message) {
    $colors = [
        'success' => 'bg-green-50 border-green-200 text-green-700',
        'error' => 'bg-red-50 border-red-200 text-red-700',
        'warning' => 'bg-yellow-50 border-yellow-200 text-yellow-700',
        'info' => 'bg-blue-50 border-blue-200 text-blue-700'
    ];
    $icons = [
        'success' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>',
        'error' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
        'warning' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>',
        'info' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>'
    ];
    $color = $colors[$type] ?? $colors['info'];
    $icon = $icons[$type] ?? $icons['info'];
    echo '<div class="mb-6 p-4 ' . $color . ' border rounded-xl flex items-center gap-3">
        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">' . $icon . '</svg>
        <span>' . htmlspecialchars($message) . '</span>
    </div>';
}

// Form input field
function adminInput($name, $label, $value = '', $type = 'text', $required = true, $placeholder = '') {
    $req = $required ? 'required' : '';
    $ph = $placeholder ?: "Enter $label";
    $val = htmlspecialchars(html_entity_decode($value, ENT_QUOTES, 'UTF-8'));
    echo '<div class="mb-4">
        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">' . htmlspecialchars($label) . '</label>
        <input type="' . $type . '" name="' . $name . '" value="' . $val . '" ' . $req . '
            class="w-full px-4 py-3 border-2 border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 rounded-xl focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none transition-colors"
            placeholder="' . htmlspecialchars($ph) . '">
    </div>';
}

// Form textarea
function adminTextarea($name, $label, $value = '', $rows = 6, $editor = false) {
    $editorClass = $editor ? ' editor' : '';
    echo '<div class="mb-4">
        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">' . htmlspecialchars($label) . '</label>
        <textarea name="' . $name . '" rows="' . $rows . '"
            class="w-full px-4 py-3 border-2 border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 rounded-xl focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none transition-colors' . $editorClass . '">' . $value . '</textarea>
    </div>';
}

// Form file upload
function adminFileUpload($name, $label, $currentImage = '', $required = false) {
    $req = $required ? 'required' : '';
    if ($currentImage && $currentImage !== '../ ') {
        echo '<div class="mb-4">
            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Current Image</label>
            <div class="w-32 h-32 rounded-xl overflow-hidden border-2 border-slate-300 dark:border-slate-600 mb-3">
                <img src="' . htmlspecialchars($currentImage) . '" alt="" class="w-full h-full object-cover">
            </div>
            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">' . htmlspecialchars($label) . ' (optional - leave empty to keep current)</label>
        </div>';
    } else {
        echo '<div class="mb-4"><label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">' . htmlspecialchars($label) . '</label>';
    }
    echo '<input name="' . $name . '" type="file" accept="image/*" ' . $req . '
        class="w-full cursor-pointer file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-primary-50 file:text-primary-600 hover:file:bg-primary-100 dark:file:bg-primary-900/30 dark:file:text-primary-400 border-2 border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 rounded-xl p-2">
    </div>';
}

// CSRF token hidden field for forms
function adminCsrfField() {
    if (function_exists('csrfField')) {
        echo csrfField();
    }
}

// Validate CSRF on form submission
function adminValidateCsrf() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (function_exists('validateCsrfToken') && !validateCsrfToken()) {
            adminAlert('error', 'Security token expired. Please refresh the page and try again.');
            return false;
        }
    }
    return true;
}

// Form buttons with CSRF token
function adminFormButtons($backUrl, $submitText = 'Save', $submitName = 'publish') {
    // Include CSRF token in form
    adminCsrfField();
    echo '<div class="flex justify-end gap-3 pt-4 border-t border-slate-200 dark:border-slate-700 mt-6">
        <a href="' . htmlspecialchars($backUrl) . '" class="px-6 py-3 bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-xl font-medium hover:bg-slate-200 dark:hover:bg-slate-600 transition-colors">Cancel</a>
        <button type="submit" name="' . htmlspecialchars($submitName) . '" class="px-6 py-3 bg-gradient-to-r from-primary-500 to-secondary-400 text-white rounded-xl font-medium hover:shadow-lg transition-all flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            ' . htmlspecialchars($submitText) . '
        </button>
    </div>';
}

// Table start
function adminTableStart($columns) {
    echo '<div class="overflow-x-auto"><table id="dyntable" class="w-full"><thead><tr class="bg-slate-50 dark:bg-slate-700">';
    foreach ($columns as $col) {
        $align = $col['align'] ?? 'left';
        $width = isset($col['width']) ? ' w-' . $col['width'] : '';
        echo '<th class="px-4 py-3 text-' . $align . ' text-sm font-semibold text-slate-700 dark:text-slate-300' . $width . '">' . htmlspecialchars($col['label']) . '</th>';
    }
    echo '</tr></thead><tbody class="divide-y divide-slate-100 dark:divide-slate-700">';
}

function adminTableEnd() {
    echo '</tbody></table></div>';
}

// Table cell with image thumbnail
function adminTableImage($src, $sizeClass = 'w-12 h-12', $rounded = false) {
    $roundedClass = $rounded ? 'rounded-full' : 'rounded-lg';
    // Handle both relative and absolute paths
    $imgSrc = (strpos($src, '../') === 0) ? htmlspecialchars($src) : htmlspecialchars($src);
    return '<div class="' . $sizeClass . ' ' . $roundedClass . ' overflow-hidden bg-slate-100 border-2 border-slate-200">
        <img src="' . $imgSrc . '" alt="" class="w-full h-full object-cover">
    </div>';
}

// Table action buttons
function adminTableActions($baseUrl, $id, $actions = ['view', 'edit', 'delete'], $confirmDelete = true) {
    $buttons = '';
    $actionConfig = [
        'view' => ['color' => 'green', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>'],
        'edit' => ['color' => 'blue', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>'],
        'delete' => ['color' => 'red', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>']
    ];

    foreach ($actions as $action) {
        if (!isset($actionConfig[$action])) continue;
        $cfg = $actionConfig[$action];
        $url = $baseUrl . '?action=' . $action . '&id=' . $id;
        $confirm = ($action === 'delete' && $confirmDelete) ? ' onclick="return confirm(\'Are you sure?\')"' : '';
        $buttons .= '<a href="' . htmlspecialchars($url) . '" class="p-2 rounded-lg text-slate-500 hover:text-' . $cfg['color'] . '-600 hover:bg-' . $cfg['color'] . '-50 transition-colors" title="' . ucfirst($action) . '"' . $confirm . '>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">' . $cfg['icon'] . '</svg>
        </a>';
    }
    return '<div class="flex items-center justify-center gap-1">' . $buttons . '</div>';
}

// Badge
function adminBadge($text, $color = 'blue') {
    return '<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-' . $color . '-100 text-' . $color . '-700">' . htmlspecialchars($text) . '</span>';
}

// Order number circle
function adminOrderBadge($num) {
    return '<span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-slate-100 text-slate-700 font-medium text-sm">' . htmlspecialchars($num) . '</span>';
}

// Delete success page
function adminDeleteSuccess($message, $redirectUrl) {
    echo '<div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 p-8 text-center">
        <div class="w-16 h-16 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
        </div>
        <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-2">' . htmlspecialchars($message) . '</h3>
        <p class="text-slate-500 dark:text-slate-400">Redirecting...</p>
    </div>';
    header("refresh:1;url=$redirectUrl");
}

// Helper function for icons
function getIcon($name) {
    $icons = [
        'add' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>',
        'edit' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>',
        'gallery' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>',
        'programs' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>',
        'team' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>',
        'video' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>',
        'image' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>',
        'star' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>',
        'users' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>',
        'user' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>',
        'user-plus' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>',
        'document' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>',
        'folder' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>',
        'question' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
        'chart' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>',
        'menu' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>'
    ];
    if (!$name || !isset($icons[$name])) return '';
    return '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">' . $icons[$name] . '</svg>';
}

// Decode HTML entities helper
function decode($str) {
    return htmlspecialchars(html_entity_decode($str, ENT_QUOTES, 'UTF-8'));
}

// Extract YouTube video ID from URL or return as-is if already an ID
function extractYoutubeId($input) {
    $input = trim($input);

    // If it's already just a video ID (11 characters, alphanumeric with - and _)
    if (preg_match('/^[a-zA-Z0-9_-]{11}$/', $input)) {
        return $input;
    }

    // Try to extract from various YouTube URL formats
    $patterns = [
        // https://www.youtube.com/watch?v=VIDEO_ID
        '/(?:youtube\.com\/watch\?v=)([a-zA-Z0-9_-]{11})/',
        // https://youtu.be/VIDEO_ID
        '/(?:youtu\.be\/)([a-zA-Z0-9_-]{11})/',
        // https://www.youtube.com/embed/VIDEO_ID
        '/(?:youtube\.com\/embed\/)([a-zA-Z0-9_-]{11})/',
        // https://www.youtube.com/v/VIDEO_ID
        '/(?:youtube\.com\/v\/)([a-zA-Z0-9_-]{11})/',
        // https://www.youtube.com/shorts/VIDEO_ID
        '/(?:youtube\.com\/shorts\/)([a-zA-Z0-9_-]{11})/',
    ];

    foreach ($patterns as $pattern) {
        if (preg_match($pattern, $input, $matches)) {
            return $matches[1];
        }
    }

    // Return original input if no pattern matched
    return $input;
}

// YouTube video input with helper text
function adminYoutubeInput($name, $label, $value = '') {
    $val = htmlspecialchars(html_entity_decode($value, ENT_QUOTES, 'UTF-8'));
    echo '<div class="mb-4">
        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">' . htmlspecialchars($label) . '</label>
        <input type="text" name="' . $name . '" value="' . $val . '" required
            class="w-full px-4 py-3 border-2 border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 rounded-xl focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none transition-colors"
            placeholder="Paste YouTube URL or Video ID">
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">You can paste the full YouTube URL (e.g., https://www.youtube.com/watch?v=xxxxx) or just the video ID</p>
    </div>';
}
