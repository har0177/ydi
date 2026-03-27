<?php require 'header.php';
$db = new database();
$page = 'profile.php';
$id = (int) $_SESSION["user_id"];

// Fetch user data
$db->query("SELECT * FROM users WHERE user_id = ?", [$id]);
$r = $db->fetchObject();

// Handle update
if (isset($_POST["update"])) {
    $login = cleanString($_POST["ulogin"]);
    $opass = cleanString($_POST["opass"]);
    $npass = cleanString($_POST["npass"]);
    $cpass = cleanString($_POST["cpass"]);
    $email = cleanString($_POST["uemail"]);
    $name = cleanString($_POST["uname"]);

    if (empty($login) || empty($opass) || empty($email) || empty($name)) {
        adminAlert('error', 'All fields are required');
    } else if (!empty($npass) && ($npass !== $cpass)) {
        adminAlert('error', 'New password must match confirmation');
    } else {
        // Get current password hash
        $db->query("SELECT user_password FROM users WHERE user_id = ?", [$id]);
        if ($db->rowCount() > 0) {
            $userData = $db->fetchObject();

            // Verify old password with migration support
            $updateCallback = function($newHash) use ($db, $id) {
                $db->query("UPDATE users SET user_password = ? WHERE user_id = ?", [$newHash, $id]);
            };

            if (verifyPassword($opass, $userData->user_password, $updateCallback)) {
                // If new password provided, hash it securely
                if (!empty($npass) && $npass === $cpass) {
                    $new_pass = securePasswordHash($npass);
                } else {
                    // Keep existing password (may have been migrated)
                    $db->query("SELECT user_password FROM users WHERE user_id = ?", [$id]);
                    $currentData = $db->fetchObject();
                    $new_pass = $currentData->user_password;
                }

                try {
                    $db->runQuery("UPDATE users SET user_login = ?, user_password = ?, user_email = ?, user_name = ? WHERE user_id = ?",
                        [$login, $new_pass, $email, $name, $id]);
                    adminAlert('success', 'Profile updated successfully!');
                    // Refresh user data
                    $db->query("SELECT * FROM users WHERE user_id = ?", [$id]);
                    $r = $db->fetchObject();
                } catch (PDOException $e) {
                    adminAlert('error', $e->getMessage());
                }
            } else {
                adminAlert('error', 'Invalid current password');
            }
        } else {
            adminAlert('error', 'User not found');
        }
    }
}

adminFormHeader('My Profile', 'user', $page);
?>

<form method="POST" action="<?php echo htmlspecialchars($_SERVER["REQUEST_URI"]); ?>" class="space-y-6">
    <!-- Profile Info Section -->
    <div class="bg-gradient-to-r from-primary-50 to-secondary-50 dark:from-slate-700 dark:to-slate-600 rounded-xl p-6 mb-6">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 bg-gradient-to-br from-primary-500 to-secondary-400 rounded-full flex items-center justify-center text-white text-2xl font-bold shadow-lg">
                <?php echo strtoupper(substr($r->user_name ?? 'U', 0, 1)); ?>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-slate-800 dark:text-white"><?php echo htmlspecialchars($r->user_name ?? ''); ?></h3>
                <p class="text-slate-500 dark:text-slate-400"><?php echo htmlspecialchars($r->user_email ?? ''); ?></p>
            </div>
        </div>
    </div>

    <!-- Account Information -->
    <div class="space-y-4">
        <h4 class="text-sm font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Account Information</h4>

        <?php adminInput('ulogin', 'Username', $r->user_login ?? ''); ?>
        <?php adminInput('uname', 'Full Name', $r->user_name ?? ''); ?>
        <?php adminInput('uemail', 'Email Address', $r->user_email ?? '', 'email'); ?>
    </div>

    <!-- Password Section -->
    <div class="space-y-4 pt-4 border-t border-slate-200 dark:border-slate-600">
        <h4 class="text-sm font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Security</h4>

        <div class="mb-4">
            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                Current Password <span class="text-red-500">*</span>
            </label>
            <input type="password" name="opass" required
                class="w-full px-4 py-3 border-2 border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 rounded-xl focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none transition-all"
                placeholder="Enter your current password">
            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
                <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Required to save any changes
            </p>
        </div>

        <div class="bg-slate-50 dark:bg-slate-700/50 rounded-xl p-4 space-y-4">
            <p class="text-sm text-slate-600 dark:text-slate-400 flex items-center gap-2">
                <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                </svg>
                Change Password (optional)
            </p>

            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">New Password</label>
                    <input type="password" name="npass"
                        class="w-full px-4 py-3 border-2 border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 rounded-xl focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none transition-all"
                        placeholder="Leave blank to keep current">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Confirm New Password</label>
                    <input type="password" name="cpass"
                        class="w-full px-4 py-3 border-2 border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 rounded-xl focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none transition-all"
                        placeholder="Confirm new password">
                </div>
            </div>
        </div>
    </div>

    <!-- Submit Button -->
    <div class="flex justify-end pt-4">
        <button type="submit" name="update" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-primary-500 to-secondary-400 text-white rounded-xl font-medium hover:shadow-lg hover:shadow-primary-500/30 transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            Update Profile
        </button>
    </div>
</form>

<?php
adminFooter();
require 'footer.php';
?>
