<?php require_once 'header.php';
$tools = new tools();
$page = 'tools.php?do=manage-backups';

/**
 * Validate backup filename to prevent path traversal
 */
function validateBackupFilename($filename) {
    $filename = basename($filename);
    if (!preg_match('/^[a-zA-Z0-9_\-\.]+$/', $filename)) {
        return false;
    }
    if (strpos($filename, '..') !== false) {
        return false;
    }
    return $filename;
}

if (isset($_GET['do'])) {
    $do = cleanString($_GET['do']);

    if ($do === 'manage-backups') {
        adminHeader('Database & File Backups', 'folder', '', '');

        // Handle actions BEFORE displaying buttons
        $actionProcessed = false;
        if (isset($_GET['action'])) {
            $act = cleanString($_GET['action']);
            switch ($act) {
                case 'delete_db':
                    if (isset($_GET['fid'])) {
                        $fid = validateBackupFilename($_GET['fid']);
                        if ($fid === false) {
                            adminAlert('error', 'Invalid file name');
                        } else {
                            $tools->delete_sql($fid);
                        }
                    } else {
                        adminAlert('error', 'Incorrect file name');
                    }
                    $actionProcessed = true;
                    break;
                case 'backup-database':
                    if ($tools->backup_database("*")) {
                        adminAlert('success', 'Database backup created successfully!');
                    } else {
                        adminAlert('error', 'Failed to create database backup');
                    }
                    $actionProcessed = true;
                    break;
                case 'download_db':
                    if (isset($_GET['fid'])) {
                        $fid = validateBackupFilename($_GET['fid']);
                        if ($fid === false) {
                            adminAlert('error', 'Invalid file name');
                        } else {
                            $file = $fid . ".sql";
                            $fullPath = realpath('../content/backup/' . $file);
                            $backupDir = realpath('../content/backup/');
                            if ($fullPath && strpos($fullPath, $backupDir) === 0 && file_exists($fullPath)) {
                                adminAlert('info', 'Your download will start in a second...');
                                header("refresh:1;url=../content/backup/$file");
                            } else {
                                adminAlert('error', 'File not found');
                            }
                        }
                    }
                    $actionProcessed = true;
                    break;
                case 'backup-files':
                    $tools->backup_files();
                    $actionProcessed = true;
                    break;
                case 'delete_files':
                    if (isset($_GET['fid'])) {
                        $fid = validateBackupFilename($_GET['fid']);
                        if ($fid === false) {
                            adminAlert('error', 'Invalid file name');
                        } else {
                            $tools->delete_files($fid);
                        }
                    } else {
                        adminAlert('error', 'Incorrect file name');
                    }
                    $actionProcessed = true;
                    break;
                case 'download_files':
                    if (isset($_GET['fid'])) {
                        $fid = validateBackupFilename($_GET['fid']);
                        if ($fid === false) {
                            adminAlert('error', 'Invalid file name');
                        } else {
                            $file = $fid . ".zip";
                            $fullPath = realpath('../content/backup/' . $file);
                            $backupDir = realpath('../content/backup/');
                            if ($fullPath && strpos($fullPath, $backupDir) === 0 && file_exists($fullPath)) {
                                adminAlert('info', 'Your download will start in a second...');
                                header("refresh:1;url=../content/backup/$file");
                            } else {
                                adminAlert('error', 'File not found');
                            }
                        }
                    }
                    $actionProcessed = true;
                    break;
            }

            // Redirect after action to prevent refresh issues
            if ($actionProcessed && $act !== 'download_db' && $act !== 'download_files') {
                echo '<script>setTimeout(function(){ window.location.href="tools.php?do=manage-backups"; }, 1500);</script>';
            }
        }

        // Action buttons with loading state
        echo '<div class="flex flex-wrap gap-3 mb-6">
            <button onclick="backupDatabase(this)" class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-primary-500 to-secondary-400 text-white rounded-lg font-medium hover:shadow-lg transition-all disabled:opacity-50 disabled:cursor-wait">
                <svg class="w-5 h-5 backup-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/></svg>
                <svg class="w-5 h-5 loading-icon hidden animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                <span class="btn-text">Backup Database</span>
            </button>
            <button onclick="backupFiles(this)" class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg font-medium hover:shadow-lg transition-all disabled:opacity-50 disabled:cursor-wait">
                <svg class="w-5 h-5 backup-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>
                <svg class="w-5 h-5 loading-icon hidden animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                <span class="btn-text">Backup Website Files</span>
            </button>
        </div>

        <script>
        function backupDatabase(btn) {
            btn.disabled = true;
            btn.querySelector(".backup-icon").classList.add("hidden");
            btn.querySelector(".loading-icon").classList.remove("hidden");
            btn.querySelector(".btn-text").textContent = "Creating backup...";
            window.location.href = "tools.php?do=manage-backups&action=backup-database";
        }
        function backupFiles(btn) {
            btn.disabled = true;
            btn.querySelector(".backup-icon").classList.add("hidden");
            btn.querySelector(".loading-icon").classList.remove("hidden");
            btn.querySelector(".btn-text").textContent = "Creating backup...";
            window.location.href = "tools.php?do=manage-backups&action=backup-files";
        }
        </script>';

        // Database Backups Section
        echo '<div class="mb-8">
            <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/></svg>
                Database Backups
            </h3>
            <div class="overflow-x-auto rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800">
                <table class="w-full table-fixed">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-700/50 border-b border-slate-200 dark:border-slate-700">
                            <th class="w-16 px-4 py-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">#</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">File Name</th>
                            <th class="w-24 px-4 py-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Size</th>
                            <th class="w-44 px-4 py-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Date</th>
                            <th class="w-28 px-4 py-3 text-center text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-700">';

        $backupPath = '../content/backup/';
        $sqlFiles = glob($backupPath . '*.sql');
        rsort($sqlFiles);

        if (count($sqlFiles) > 0) {
            $i = 1;
            foreach ($sqlFiles as $file) {
                $fileName = basename($file, '.sql');
                $fileSize = filesize($file);
                $sizeFormatted = $fileSize > 1048576 ? round($fileSize / 1048576, 2) . ' MB' : round($fileSize / 1024, 2) . ' KB';
                $fileDate = date('M d, Y H:i', filemtime($file));

                echo '<tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50">
                    <td class="px-4 py-3">' . adminOrderBadge($i++) . '</td>
                    <td class="px-4 py-3">
                        <span class="font-medium text-slate-800 dark:text-slate-200 break-all">' . htmlspecialchars($fileName) . '.sql</span>
                    </td>
                    <td class="px-4 py-3 text-slate-600 dark:text-slate-400 whitespace-nowrap">' . $sizeFormatted . '</td>
                    <td class="px-4 py-3 text-slate-600 dark:text-slate-400 whitespace-nowrap">' . $fileDate . '</td>
                    <td class="px-4 py-3">
                        <div class="flex items-center justify-center gap-1">
                            <a href="tools.php?do=manage-backups&action=download_db&fid=' . urlencode($fileName) . '" class="p-2 rounded-lg text-slate-500 hover:text-green-600 hover:bg-green-50 dark:hover:bg-green-900/20 transition-colors" title="Download">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            </a>
                            <a href="tools.php?do=manage-backups&action=delete_db&fid=' . urlencode($fileName) . '" onclick="return confirm(\'Delete this backup?\')" class="p-2 rounded-lg text-slate-500 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors" title="Delete">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </a>
                        </div>
                    </td>
                </tr>';
            }
        } else {
            echo '<tr><td colspan="5" class="px-4 py-8 text-center text-slate-500 dark:text-slate-400">No database backups found</td></tr>';
        }

        echo '</tbody></table></div></div>';

        // File Backups Section
        echo '<div>
            <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>
                File Backups
            </h3>
            <div class="overflow-x-auto rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800">
                <table class="w-full table-fixed">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-700/50 border-b border-slate-200 dark:border-slate-700">
                            <th class="w-16 px-4 py-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">#</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">File Name</th>
                            <th class="w-24 px-4 py-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Size</th>
                            <th class="w-44 px-4 py-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Date</th>
                            <th class="w-28 px-4 py-3 text-center text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-700">';

        $zipFiles = glob($backupPath . '*.zip');
        rsort($zipFiles);

        if (count($zipFiles) > 0) {
            $i = 1;
            foreach ($zipFiles as $file) {
                $fileName = basename($file, '.zip');
                $fileSize = filesize($file);
                $sizeFormatted = $fileSize > 1048576 ? round($fileSize / 1048576, 2) . ' MB' : round($fileSize / 1024, 2) . ' KB';
                $fileDate = date('M d, Y H:i', filemtime($file));

                echo '<tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50">
                    <td class="px-4 py-3">' . adminOrderBadge($i++) . '</td>
                    <td class="px-4 py-3">
                        <span class="font-medium text-slate-800 dark:text-slate-200 break-all">' . htmlspecialchars($fileName) . '.zip</span>
                    </td>
                    <td class="px-4 py-3 text-slate-600 dark:text-slate-400 whitespace-nowrap">' . $sizeFormatted . '</td>
                    <td class="px-4 py-3 text-slate-600 dark:text-slate-400 whitespace-nowrap">' . $fileDate . '</td>
                    <td class="px-4 py-3">
                        <div class="flex items-center justify-center gap-1">
                            <a href="tools.php?do=manage-backups&action=download_files&fid=' . urlencode($fileName) . '" class="p-2 rounded-lg text-slate-500 hover:text-green-600 hover:bg-green-50 dark:hover:bg-green-900/20 transition-colors" title="Download">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            </a>
                            <a href="tools.php?do=manage-backups&action=delete_files&fid=' . urlencode($fileName) . '" onclick="return confirm(\'Delete this backup?\')" class="p-2 rounded-lg text-slate-500 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors" title="Delete">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </a>
                        </div>
                    </td>
                </tr>';
            }
        } else {
            echo '<tr><td colspan="5" class="px-4 py-8 text-center text-slate-500 dark:text-slate-400">No file backups found</td></tr>';
        }

        echo '</tbody></table></div></div>';

        adminFooter();
    }
}

require_once 'footer.php';
