<?php
require_once 'config.php';
require_once 'inc/loader.php';
require_once 'inc/csrf.php';

// Security headers for public site
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: SAMEORIGIN");
header("X-XSS-Protection: 1; mode=block");
header("Referrer-Policy: strict-origin-when-cross-origin");
?>
<?php
// Fetch menu data ONCE for both desktop and mobile nav
$menuDb = new database();
$menuDb->query("SELECT * FROM menus WHERE parent_id IS NULL ORDER BY menu_order ASC");
$mainMenus = [];
while ($m = $menuDb->fetchObject()) {
    $subDb = new database();
    $subDb->query("SELECT * FROM menus WHERE parent_id = ? ORDER BY menu_order ASC", array($m->menu_id));
    $subs = [];
    while ($s = $subDb->fetchObject()) {
        $subs[] = $s;
    }
    $mainMenus[] = ['item' => $m, 'children' => $subs];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- SEO Meta Tags -->
    <meta property="og:url" content="https://www.ydi.edu.pk/" />
    <meta property="og:type" content="Youth Development Institute" />
    <meta property="og:title" content="YDI Swat" />
    <meta name="keywords" content="ydi swat, ydi, YDI, english training, english institute, in house training, training, teacher training, English proficiency, teachers' development, computer literacy, ielts training, british council, akmal khan, youth development institute, youth development, xpertzdev, YDI Media College, training and consultancy, schools development">
    <meta name="description" content="YDI Swat has dedicated resources to continuous research and development. Our R & D enabled us to design effective In house training on topics including English proficiency, teachers' development, computer literacy etc." />
    <meta property="og:image" content="https://www.ydi.edu.pk/content/img/logo-school.png" />

    <title>YDI Swat - Youth Development Institute</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="content/img/favicon.png">

    <!-- Preconnect to external origins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdn.tailwindcss.com" crossorigin>
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="dns-prefetch" href="https://img.youtube.com">

    <!-- Google Fonts (swap=display for fast first paint) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Poppins:wght@500;600;700;800&display=swap" rel="stylesheet">

    <?php include 'inc/tailwind-config.php'; ?>

    <!-- Alpine.js (pinned versions) -->
    <script defer src="https://unpkg.com/@alpinejs/collapse@3.14.8/dist/cdn.min.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.14.8/dist/cdn.min.js"></script>

    <!-- Fancybox CSS (pinned version) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0.36/dist/fancybox/fancybox.css"/>

    <style>
        [x-cloak] { display: none !important; }
        html { scroll-behavior: smooth; }

        @keyframes float { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-20px); } }
        .animate-float { animation: float 6s ease-in-out infinite; }

        @keyframes slideUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        .animate-slide-up { animation: slideUp 0.6s ease-out forwards; }

        .gradient-text {
            background: linear-gradient(135deg, #7c3aed, #1e40af);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .card-hover { transition: all 0.3s ease; }
        .card-hover:hover { transform: translateY(-8px); box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15); }

        .img-zoom { overflow: hidden; }
        .img-zoom img { transition: transform 0.5s ease; }
        .img-zoom:hover img { transform: scale(1.1); }

        .grayscale-hover { filter: grayscale(100%); transition: filter 0.3s ease; }
        .grayscale-hover:hover { filter: grayscale(0%); }

        .btn-shine { position: relative; overflow: hidden; }
        .btn-shine::after {
            content: ''; position: absolute; top: -50%; left: -50%; width: 200%; height: 200%;
            background: linear-gradient(to right, transparent, rgba(255,255,255,0.3), transparent);
            transform: rotate(45deg) translateX(-100%); transition: transform 0.6s;
        }
        .btn-shine:hover::after { transform: rotate(45deg) translateX(100%); }

        .wave-bg {
            position: absolute; bottom: 0; left: 0; width: 100%; height: 100px;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1440 320'%3E%3Cpath fill='%23ffffff' fill-opacity='1' d='M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,154.7C960,171,1056,181,1152,165.3C1248,149,1344,107,1392,85.3L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z'%3E%3C/path%3E%3C/svg%3E") no-repeat bottom;
            background-size: cover;
        }
        .dark .wave-bg {
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1440 320'%3E%3Cpath fill='%230f172a' fill-opacity='1' d='M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,154.7C960,171,1056,181,1152,165.3C1248,149,1344,107,1392,85.3L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z'%3E%3C/path%3E%3C/svg%3E") no-repeat bottom;
            background-size: cover;
        }

        /* Page title section for inner pages */
        .page-title-section {
            background: linear-gradient(135deg, #7c3aed 0%, #1e40af 100%);
            padding: 60px 0;
            margin-bottom: 40px;
        }
    </style>
</head>

<body class="font-sans bg-white text-slate-800" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true', mobileMenu: false }" :class="{ 'dark bg-slate-900 text-slate-200': darkMode }">

    <div class="min-h-screen flex flex-col">

        <!-- Header -->
        <header class="fixed top-0 left-0 right-0 z-50 bg-white dark:bg-slate-900 shadow-md transition-all duration-300" id="pageTop">
            <div class="h-1 bg-gradient-to-r from-primary-500 via-secondary-500 to-primary-500"></div>

            <nav class="container mx-auto px-4 lg:px-8">
                <div class="flex items-center justify-between h-16 lg:h-20">
                    <!-- Logo -->
                    <a href="index.php" class="flex-shrink-0">
                        <img src="content/img/logo-school.png" alt="YDI" class="h-12 lg:h-14 w-auto drop-shadow-lg hover:drop-shadow-xl hover:scale-105 transition-all duration-300" fetchpriority="high">
                    </a>

                    <!-- Desktop Navigation -->
                    <div class="hidden lg:flex items-center space-x-1">
                        <a href="index.php" class="px-4 py-2 text-sm font-medium text-primary-500 hover:text-primary-600 transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            Home
                        </a>

                        <?php foreach ($mainMenus as $menuEntry) {
    $men = $menuEntry['item'];
    $children = $menuEntry['children'];
    if (!empty($children)) { ?>
                                <div class="relative group">
                                    <button class="flex items-center gap-1 px-4 py-2 text-sm font-medium text-slate-700 dark:text-slate-300 hover:text-primary-500 transition-colors">
                                        <?php echo safeHtml($men->menu_label); ?>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </button>
                                    <div class="absolute top-full left-0 mt-1 w-56 bg-white dark:bg-slate-800 rounded-xl shadow-xl border border-slate-200 dark:border-slate-700 py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform translate-y-2 group-hover:translate-y-0">
                                        <?php foreach ($children as $sub) { ?>
                                            <a href="<?php echo htmlspecialchars($sub->menu_link); ?>" class="block px-4 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-primary-50 dark:hover:bg-slate-700 hover:text-primary-500 transition-colors">
                                                <?php echo safeHtml($sub->menu_label); ?>
                                            </a>
                                        <?php } ?>
                                    </div>
                                </div>
                        <?php } else { ?>
                                <a href="<?php echo htmlspecialchars($men->menu_link); ?>" class="px-4 py-2 text-sm font-medium text-slate-700 dark:text-slate-300 hover:text-primary-500 transition-colors">
                                    <?php echo safeHtml($men->menu_label); ?>
                                </a>
                        <?php }
} ?>

                        <a href="https://www.portal.ydi.edu.pk/" class="ml-2 px-5 py-2 bg-gradient-to-r from-primary-500 to-secondary-500 text-white text-sm font-medium rounded-full hover:shadow-lg hover:shadow-primary-500/30 transition-all duration-300 hover:-translate-y-0.5">
                            Student Portal
                        </a>

                        <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)" class="ml-2 p-2 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">
                            <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                            </svg>
                            <svg x-show="darkMode" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </button>
                    </div>

                    <!-- Mobile menu button -->
                    <button @click="mobileMenu = !mobileMenu" class="lg:hidden p-2 rounded-lg text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800">
                        <svg x-show="!mobileMenu" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        <svg x-show="mobileMenu" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- Mobile Navigation -->
                <div x-show="mobileMenu" x-cloak x-collapse class="lg:hidden py-4 border-t border-slate-200 dark:border-slate-700">
                    <div class="flex flex-col space-y-1">
                        <a href="index.php" class="px-4 py-3 text-primary-500 font-medium rounded-lg hover:bg-primary-50 dark:hover:bg-slate-800">Home</a>

                        <?php foreach ($mainMenus as $menuEntry) {
    $men_m = $menuEntry['item'];
    $children_m = $menuEntry['children'];
    if (!empty($children_m)) { ?>
                                <div x-data="{ open: false }">
                                    <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 text-slate-700 dark:text-slate-300 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800">
                                        <?php echo safeHtml($men_m->menu_label); ?>
                                        <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </button>
                                    <div x-show="open" x-cloak x-collapse class="pl-4 mt-1 space-y-1">
                                        <?php foreach ($children_m as $sub_m) { ?>
                                            <a href="<?php echo htmlspecialchars($sub_m->menu_link); ?>" class="block px-4 py-2 text-sm text-slate-600 dark:text-slate-400 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-primary-500">
                                                <?php echo safeHtml($sub_m->menu_label); ?>
                                            </a>
                                        <?php } ?>
                                    </div>
                                </div>
                        <?php } else { ?>
                                <a href="<?php echo htmlspecialchars($men_m->menu_link); ?>" class="px-4 py-3 text-slate-700 dark:text-slate-300 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800">
                                    <?php echo safeHtml($men_m->menu_label); ?>
                                </a>
                        <?php }
} ?>

                        <div class="pt-4 mt-4 border-t border-slate-200 dark:border-slate-700">
                            <a href="https://www.portal.ydi.edu.pk/" class="block w-full text-center px-4 py-3 bg-gradient-to-r from-primary-500 to-secondary-500 text-white font-medium rounded-lg">Student Portal</a>
                            <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)" class="w-full mt-3 flex items-center justify-center gap-2 px-4 py-3 bg-slate-100 dark:bg-slate-800 rounded-lg text-slate-700 dark:text-slate-300">
                                <span x-text="darkMode ? 'Light Mode' : 'Dark Mode'"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </nav>
        </header>

        <!-- Floating Quiz Button -->
        <a href="quiz.php" class="fixed right-0 top-1/2 transform -translate-y-1/2 z-40 px-4 py-3 bg-gradient-to-r from-primary-600 to-primary-500 text-white text-sm font-bold rounded-l-full shadow-lg hover:shadow-xl hover:-translate-x-1 transition-all duration-300 flex items-center gap-2">
            <span class="relative flex h-3 w-3">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                <span class="relative inline-flex rounded-full h-3 w-3 bg-white"></span>
            </span>
            Quizzes
        </a>

        <!-- Spacer for fixed header -->
        <div class="h-16 lg:h-20"></div>

        <?php
        if ((isset($_POST['name']) && !empty($_POST['name'])) && (isset($_POST['email']) && !empty($_POST['email'])) && (isset($_POST['subject']) && !empty($_POST['subject']))) {
            if (validateCsrfToken()) {
                $name = htmlspecialchars($_POST['name']);
                $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
                $subject = htmlspecialchars($_POST['subject']);
                $message = htmlspecialchars($_POST['msg'] ?? '');

                $to = "hr@ydi.edu.pk";
                $headers = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'From:' . $email . "\r\n";
                $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

                if (mail($to, $subject, $message, $headers)) {
                    echo '<div class="fixed top-24 left-1/2 transform -translate-x-1/2 z-50 px-6 py-3 bg-accent-500 text-white rounded-lg shadow-lg animate-slide-up">
                        E-Mail sent successfully! We will get back to you soon.
                    </div>';
                }
            }
        }
        ?>
