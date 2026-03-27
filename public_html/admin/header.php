<?php
require '../config.php';
require '../inc/loader.php';
require __DIR__ . '/inc/admin_ui.php';
ob_start();
session_start();

// Session security configuration
define('SESSION_TIMEOUT', 3600); // 1 hour session timeout

// Check if user is logged in
if (!isset($_SESSION["user_id"]) || !isset($_SESSION["user_level"])) {
    header("Location: login.php");
    exit();
}

// Session timeout check
if (isset($_SESSION['last_activity'])) {
    if (time() - $_SESSION['last_activity'] > SESSION_TIMEOUT) {
        // Session expired
        session_unset();
        session_destroy();
        header("Location: login.php?expired=1");
        exit();
    }
}
$_SESSION['last_activity'] = time();

// Regenerate session ID periodically to prevent session fixation
if (!isset($_SESSION['session_created'])) {
    $_SESSION['session_created'] = time();
} else if (time() - $_SESSION['session_created'] > 1800) {
    // Regenerate session ID every 30 minutes
    session_regenerate_id(true);
    $_SESSION['session_created'] = time();
}

$name = $_SESSION["user_name"] ?? '';

// Security headers
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: DENY");
header("X-XSS-Protection: 1; mode=block");
header("Referrer-Policy: strict-origin-when-cross-origin");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>YDI - Admin Panel</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="../content/img/favicon.png">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <?php include '../inc/tailwind-config.php'; ?>
    <script>
        // Dark mode toggle
        if (localStorage.getItem('darkMode') === 'true' || (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
        function toggleDarkMode() {
            document.documentElement.classList.toggle('dark');
            localStorage.setItem('darkMode', document.documentElement.classList.contains('dark'));
        }
    </script>

    <!-- Alpine.js -->
    <script src="https://unpkg.com/alpinejs@3.13.3/dist/cdn.min.js" defer></script>

    <!-- jQuery for legacy compatibility -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- TinyMCE -->
    <script src="../content/assets/plugins/tinymce/js/tinymce/tinymce.jquery.min.js"></script>
    <script>
    $(document).ready(function() {
        if (typeof tinymce !== 'undefined') {
            tinymce.init({
                selector: "textarea.editor",
                theme: "modern",
                paste_data_images: true,
                plugins: [
                    "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                    "searchreplace wordcount visualblocks visualchars code fullscreen",
                    "insertdatetime media nonbreaking save table contextmenu directionality",
                    "emoticons template paste textcolor colorpicker textpattern"
                ],
                toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | fontsizeselect link image",
                toolbar2: "print preview media | forecolor backcolor emoticons",
                image_advtab: true,
                file_picker_callback: function(callback, value, meta) {
                    if (meta.filetype == 'image') {
                        $('#upload').trigger('click');
                        $('#upload').on('change', function() {
                            var file = this.files[0];
                            var reader = new FileReader();
                            reader.onload = function(e) {
                                callback(e.target.result, { alt: '' });
                            };
                            reader.readAsDataURL(file);
                        });
                    }
                }
            });
        }
    });
    </script>

    <style>
        [x-cloak] { display: none !important; }
        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        .dark ::-webkit-scrollbar-track { background: #1e293b; }
        .dark ::-webkit-scrollbar-thumb { background: #475569; }
        .dark ::-webkit-scrollbar-thumb:hover { background: #64748b; }
    </style>
</head>
<body class="font-sans bg-slate-100 dark:bg-slate-900 min-h-screen transition-colors" x-data="{ sidebarOpen: window.innerWidth >= 1024, userDropdown: false }">

    <!-- Top Header Bar -->
    <header class="fixed top-0 left-0 right-0 h-16 bg-white dark:bg-slate-800 shadow-sm dark:shadow-slate-900/50 z-40 flex items-center justify-between px-4 lg:px-6 transition-colors">
        <!-- Left: Logo & Toggle -->
        <div class="flex items-center gap-4">
            <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors lg:hidden">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            <a href="index.php" class="flex items-center gap-3">
                <img src="../content/img/logo-school.png" alt="YDI" class="h-10">
                <span class="font-bold text-lg text-slate-800 dark:text-white hidden sm:inline">Admin Panel</span>
            </a>
        </div>

        <!-- Right: User Menu -->
        <div class="flex items-center gap-4">
            <!-- Dark Mode Toggle -->
            <button onclick="toggleDarkMode()" class="p-2 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors" title="Toggle Dark Mode">
                <svg class="w-5 h-5 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                <svg class="w-5 h-5 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                </svg>
            </button>
            <a href="../index.php" class="hidden sm:flex items-center gap-2 px-4 py-2 text-slate-600 dark:text-slate-300 hover:text-primary-500 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                View Site
            </a>

            <!-- User Dropdown -->
            <div class="relative" @click.away="userDropdown = false">
                <button @click="userDropdown = !userDropdown" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                    <div class="w-9 h-9 bg-gradient-to-r from-primary-500 to-secondary-400 rounded-full flex items-center justify-center text-white font-semibold">
                        <?php echo strtoupper(substr($name, 0, 1)); ?>
                    </div>
                    <span class="text-slate-700 dark:text-slate-200 font-medium hidden sm:inline"><?php echo htmlspecialchars($name); ?></span>
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="userDropdown" x-cloak
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     class="absolute right-0 mt-2 w-48 bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 py-2 z-50">
                    <a href="profile.php" class="flex items-center gap-3 px-4 py-2 text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-primary-500 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Profile
                    </a>
                    <hr class="my-2 border-slate-100 dark:border-slate-700">
                    <a href="login.php?do=logout" class="flex items-center gap-3 px-4 py-2 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Logout
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Sidebar -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
           class="fixed top-16 left-0 bottom-0 w-64 bg-white dark:bg-slate-800 shadow-lg dark:shadow-slate-900/50 z-30 transition-transform duration-300 lg:translate-x-0 overflow-y-auto">
        <nav class="p-4">
            <div class="mb-4">
                <p class="text-xs font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-2">Main Menu</p>
                <a href="index.php" class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-700 dark:text-slate-300 hover:bg-primary-50 dark:hover:bg-primary-900/20 hover:text-primary-500 transition-colors <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-500' : ''; ?>">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                    </svg>
                    Dashboard
                </a>
            </div>

            <div class="mb-4">
                <p class="text-xs font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-2">Content</p>
                <div class="space-y-1">
                    <a href="slider.php" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-primary-500 transition-colors <?php echo basename($_SERVER['PHP_SELF']) == 'slider.php' ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-500' : ''; ?>">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Slider
                    </a>
                    <a href="features.php" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-primary-500 transition-colors <?php echo basename($_SERVER['PHP_SELF']) == 'features.php' ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-500' : ''; ?>">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                        Features
                    </a>
                    <a href="programs.php" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-primary-500 transition-colors <?php echo basename($_SERVER['PHP_SELF']) == 'programs.php' ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-500' : ''; ?>">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        Programs
                    </a>
                    <a href="gallery.php" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-primary-500 transition-colors <?php echo basename($_SERVER['PHP_SELF']) == 'gallery.php' ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-500' : ''; ?>">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                        Gallery
                    </a>
                    <a href="videos.php" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-primary-500 transition-colors <?php echo basename($_SERVER['PHP_SELF']) == 'videos.php' ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-500' : ''; ?>">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        Videos
                    </a>
                    <a href="pages.php" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-primary-500 transition-colors <?php echo basename($_SERVER['PHP_SELF']) == 'pages.php' ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-500' : ''; ?>">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Pages
                    </a>
                </div>
            </div>

            <div class="mb-4">
                <p class="text-xs font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-2">People</p>
                <div class="space-y-1">
                    <a href="team.php" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-primary-500 transition-colors <?php echo basename($_SERVER['PHP_SELF']) == 'team.php' ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-500' : ''; ?>">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        Team Members
                    </a>
                    <a href="alumni.php" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-primary-500 transition-colors <?php echo basename($_SERVER['PHP_SELF']) == 'alumni.php' ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-500' : ''; ?>">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/></svg>
                        Alumni
                    </a>
                    <a href="clients.php" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-primary-500 transition-colors <?php echo basename($_SERVER['PHP_SELF']) == 'clients.php' ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-500' : ''; ?>">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        Clients
                    </a>
                    <a href="users.php" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-primary-500 transition-colors <?php echo basename($_SERVER['PHP_SELF']) == 'users.php' ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-500' : ''; ?>">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        Users
                    </a>
                </div>
            </div>

            <div class="mb-4">
                <p class="text-xs font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-2">Quiz System</p>
                <div class="space-y-1">
                    <a href="topics.php" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-primary-500 transition-colors <?php echo basename($_SERVER['PHP_SELF']) == 'topics.php' ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-500' : ''; ?>">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                        Topics
                    </a>
                    <a href="quiz.php" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-primary-500 transition-colors <?php echo basename($_SERVER['PHP_SELF']) == 'quiz.php' ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-500' : ''; ?>">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Quiz Questions
                    </a>
                    <a href="marks.php" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-primary-500 transition-colors <?php echo basename($_SERVER['PHP_SELF']) == 'marks.php' ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-500' : ''; ?>">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        Student Marks
                    </a>
                </div>
            </div>

            <div class="mb-4">
                <p class="text-xs font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-2">Settings</p>
                <div class="space-y-1">
                    <a href="menus.php" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-primary-500 transition-colors <?php echo basename($_SERVER['PHP_SELF']) == 'menus.php' ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-500' : ''; ?>">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        Menus
                    </a>
                    <a href="feedback.php" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-primary-500 transition-colors <?php echo basename($_SERVER['PHP_SELF']) == 'feedback.php' ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-500' : ''; ?>">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                        Enrollments
                    </a>
                    <a href="tools.php?do=manage-backups" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-primary-500 transition-colors <?php echo basename($_SERVER['PHP_SELF']) == 'tools.php' ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-500' : ''; ?>">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/></svg>
                        Backups
                    </a>
                </div>
            </div>
        </nav>
    </aside>

    <!-- Sidebar Overlay (mobile) -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black/50 z-20 lg:hidden" x-cloak></div>

    <!-- Main Content -->
    <main class="pt-16 lg:pl-64 min-h-screen">
        <div class="p-4 lg:p-6">
