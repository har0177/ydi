<?php require 'header.php'; ?>

<!-- Dashboard Content -->
<div class="space-y-6">
    <!-- Welcome Card -->
    <div class="bg-gradient-to-r from-primary-500 to-secondary-400 rounded-2xl p-8 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold mb-2">Welcome back, <?php echo htmlspecialchars($name); ?>!</h1>
                <p class="text-white/80">Here's what's happening with your website today.</p>
            </div>
            <div class="hidden md:block">
                <svg class="w-24 h-24 text-white/20" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
        <?php
        // Get counts from database
        $stats = [
            ['label' => 'Programs', 'table' => 'programs', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>', 'color' => 'primary', 'link' => 'programs.php'],
            ['label' => 'Gallery', 'table' => 'gallery', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>', 'color' => 'purple', 'link' => 'gallery.php'],
            ['label' => 'Videos', 'table' => 'videos', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>', 'color' => 'red', 'link' => 'videos.php'],
            ['label' => 'Team', 'table' => 'team', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>', 'color' => 'blue', 'link' => 'team.php'],
        ];

        $colorClasses = [
            'primary' => ['bg' => 'bg-primary-50', 'icon' => 'bg-primary-100 text-primary-500', 'text' => 'text-primary-500'],
            'purple' => ['bg' => 'bg-purple-50', 'icon' => 'bg-purple-100 text-purple-500', 'text' => 'text-purple-500'],
            'red' => ['bg' => 'bg-red-50', 'icon' => 'bg-red-100 text-red-500', 'text' => 'text-red-500'],
            'blue' => ['bg' => 'bg-blue-50', 'icon' => 'bg-blue-100 text-blue-500', 'text' => 'text-blue-500'],
            'green' => ['bg' => 'bg-green-50', 'icon' => 'bg-green-100 text-green-500', 'text' => 'text-green-500'],
        ];

        $db = new database();
        try {
            $db->query("SELECT
                (SELECT COUNT(*) FROM programs) AS programs,
                (SELECT COUNT(*) FROM gallery) AS gallery,
                (SELECT COUNT(*) FROM videos) AS videos,
                (SELECT COUNT(*) FROM team) AS team");
            $counts = $db->fetchObject();
        } catch (Exception $e) {
            $counts = (object)['programs' => 0, 'gallery' => 0, 'videos' => 0, 'team' => 0];
        }

        foreach ($stats as $stat) {
            $count = $counts->{$stat['table']} ?? 0;

            $colors = $colorClasses[$stat['color']];
        ?>
        <a href="<?php echo $stat['link']; ?>" class="block bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 <?php echo $colors['icon']; ?> rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><?php echo $stat['icon']; ?></svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-slate-800"><?php echo $count; ?></p>
                    <p class="text-sm text-slate-500"><?php echo $stat['label']; ?></p>
                </div>
            </div>
        </a>
        <?php } ?>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-6 py-4 bg-slate-50 border-b border-slate-100">
            <h2 class="text-lg font-semibold text-slate-800">Quick Actions</h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="slider.php" class="flex flex-col items-center gap-3 p-4 rounded-xl bg-slate-50 hover:bg-primary-50 hover:text-primary-500 transition-colors">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-sm font-medium">Manage Slider</span>
                </a>
                <a href="programs.php" class="flex flex-col items-center gap-3 p-4 rounded-xl bg-slate-50 hover:bg-primary-50 hover:text-primary-500 transition-colors">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    <span class="text-sm font-medium">Add Program</span>
                </a>
                <a href="gallery.php" class="flex flex-col items-center gap-3 p-4 rounded-xl bg-slate-50 hover:bg-primary-50 hover:text-primary-500 transition-colors">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                    <span class="text-sm font-medium">Add Gallery</span>
                </a>
                <a href="videos.php" class="flex flex-col items-center gap-3 p-4 rounded-xl bg-slate-50 hover:bg-primary-50 hover:text-primary-500 transition-colors">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-sm font-medium">Add Video</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Activity / Info Cards -->
    <div class="grid lg:grid-cols-2 gap-6">
        <!-- Website Info -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-6 py-4 bg-slate-50 border-b border-slate-100">
                <h2 class="text-lg font-semibold text-slate-800">Website Info</h2>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex items-center justify-between py-3 border-b border-slate-100">
                    <span class="text-slate-600">Website URL</span>
                    <a href="https://ydi.edu.pk" target="_blank" class="text-primary-500 hover:underline">ydi.edu.pk</a>
                </div>
                <div class="flex items-center justify-between py-3 border-b border-slate-100">
                    <span class="text-slate-600">Student Portal</span>
                    <a href="https://portal.ydi.edu.pk" target="_blank" class="text-primary-500 hover:underline">portal.ydi.edu.pk</a>
                </div>
                <div class="flex items-center justify-between py-3 border-b border-slate-100">
                    <span class="text-slate-600">PHP Version</span>
                    <span class="font-mono text-slate-800"><?php echo phpversion(); ?></span>
                </div>
                <div class="flex items-center justify-between py-3">
                    <span class="text-slate-600">Server Time</span>
                    <span class="text-slate-800"><?php echo date('Y-m-d H:i:s'); ?></span>
                </div>
            </div>
        </div>

        <!-- Quick Links -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-6 py-4 bg-slate-50 border-b border-slate-100">
                <h2 class="text-lg font-semibold text-slate-800">Quick Links</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 gap-4">
                    <a href="../index.php" target="_blank" class="flex items-center gap-3 p-3 rounded-xl hover:bg-slate-50 transition-colors">
                        <div class="w-10 h-10 bg-green-100 text-green-500 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-slate-700">View Website</span>
                    </a>
                    <a href="tools.php?do=manage-backups" class="flex items-center gap-3 p-3 rounded-xl hover:bg-slate-50 transition-colors">
                        <div class="w-10 h-10 bg-blue-100 text-blue-500 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/>
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-slate-700">Backups</span>
                    </a>
                    <a href="menus.php" class="flex items-center gap-3 p-3 rounded-xl hover:bg-slate-50 transition-colors">
                        <div class="w-10 h-10 bg-purple-100 text-purple-500 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-slate-700">Menus</span>
                    </a>
                    <a href="users.php" class="flex items-center gap-3 p-3 rounded-xl hover:bg-slate-50 transition-colors">
                        <div class="w-10 h-10 bg-orange-100 text-orange-500 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-slate-700">Users</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require 'footer.php'; ?>
