<?php
require '../config.php';
require '../inc/loader.php';
require '../inc/csrf.php';
ob_start();
session_start();

// Rate limiting configuration
define('MAX_LOGIN_ATTEMPTS', 5);
define('LOCKOUT_TIME', 900); // 15 minutes in seconds

/**
 * Get client IP address
 */
function getClientIP() {
    $ip = $_SERVER['REMOTE_ADDR'];
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        $ip = trim($ips[0]);
    }
    return filter_var($ip, FILTER_VALIDATE_IP) ?: '0.0.0.0';
}

/**
 * Check if IP is rate limited
 */
function isRateLimited($ip) {
    $db = new database();
    $db->query("SELECT attempts, last_attempt FROM login_attempts WHERE ip_address = ?", [$ip]);

    if ($db->rowCount() > 0) {
        $row = $db->fetchObject();
        $timeSinceLastAttempt = time() - strtotime($row->last_attempt);

        // If lockout time has passed, reset attempts
        if ($timeSinceLastAttempt > LOCKOUT_TIME) {
            $db->runQuery("DELETE FROM login_attempts WHERE ip_address = ?", [$ip]);
            return false;
        }

        // Check if max attempts exceeded
        if ($row->attempts >= MAX_LOGIN_ATTEMPTS) {
            return LOCKOUT_TIME - $timeSinceLastAttempt; // Return seconds remaining
        }
    }
    return false;
}

/**
 * Record a failed login attempt
 */
function recordFailedAttempt($ip) {
    $db = new database();
    $db->query("SELECT * FROM login_attempts WHERE ip_address = ?", [$ip]);

    if ($db->rowCount() > 0) {
        $db->runQuery("UPDATE login_attempts SET attempts = attempts + 1, last_attempt = NOW() WHERE ip_address = ?", [$ip]);
    } else {
        $db->runQuery("INSERT INTO login_attempts (ip_address, attempts, last_attempt) VALUES (?, 1, NOW())", [$ip]);
    }
}

/**
 * Clear login attempts on successful login
 */
function clearLoginAttempts($ip) {
    $db = new database();
    $db->runQuery("DELETE FROM login_attempts WHERE ip_address = ?", [$ip]);
}

// Create login_attempts table if not exists
try {
    $db = new database();
    $db->runQuery("CREATE TABLE IF NOT EXISTS login_attempts (
        id INT AUTO_INCREMENT PRIMARY KEY,
        ip_address VARCHAR(45) NOT NULL,
        attempts INT DEFAULT 0,
        last_attempt DATETIME NOT NULL,
        UNIQUE KEY unique_ip (ip_address)
    ) ENGINE=InnoDB");
} catch (Exception $e) {
    // Table might already exist, ignore error
}

$error = '';
$success = '';
$clientIP = getClientIP();

// Check rate limiting
$lockoutSeconds = isRateLimited($clientIP);
if ($lockoutSeconds !== false) {
    $lockoutMinutes = ceil($lockoutSeconds / 60);
    $error = "Too many failed login attempts. Please try again in {$lockoutMinutes} minutes.";
}

if (isset($_POST["login"]) && $lockoutSeconds === false) {
    // Validate CSRF token
    if (!validateCsrfToken()) {
        $error = "Security token expired. Please refresh the page and try again.";
    } else {
        $name = cleanString($_POST["username"]);
        $password = cleanString($_POST["password"]);

        if(empty($name) || empty($password)){
            $error = "All fields are required.";
        }else{
            // Secure login with password migration support
            $sql = "SELECT * FROM users WHERE user_login = ? AND user_level = 'Admin'";
            $db = new database();
            try{
                $db->query($sql, array($name));
                if($db->rowCount() > 0){
                    $r = $db->fetchObject();

                    // Use secure password verification with auto-migration
                    $updateCallback = function($newHash) use ($db, $r) {
                        $db->query("UPDATE users SET user_password = ? WHERE user_id = ?",
                            array($newHash, $r->user_id));
                    };

                    if(verifyPassword($password, $r->user_password, $updateCallback)){
                        // Clear failed attempts on successful login
                        clearLoginAttempts($clientIP);

                        // Regenerate session ID to prevent session fixation
                        session_regenerate_id(true);

                        // Regenerate CSRF token
                        regenerateCsrfToken();

                        $_SESSION["user_id"] = $r->user_id;
                        $_SESSION["user_level"] = $r->user_level;
                        $_SESSION["user_name"] = $r->user_name;
                        $_SESSION["last_activity"] = time();

                        header("Location: index.php");
                        exit();
                    }else{
                        recordFailedAttempt($clientIP);
                        $error = "Invalid login details.";
                    }
                }else{
                    recordFailedAttempt($clientIP);
                    $error = "Invalid login details.";
                }
            } catch (PDOException $e){
                if (defined('APP_DEBUG') && APP_DEBUG) {
                    $error = $e->getMessage();
                } else {
                    $error = "Login failed. Please try again.";
                }
            }
        }
    }
} else if (isset($_GET["do"])){
    $do = $_GET["do"];
    if($do == "logout"){
        session_destroy();
        session_unset();
        header("Location:../index.php");
        exit();
    }
} else if (isset($_SESSION["user_id"]) && isset($_SESSION["user_level"])) {
    header("Location: index.php");
    exit();
}

// Generate CSRF token for form
$csrfToken = generateCsrfToken();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - YDI Admin Panel</title>

    <!-- Security Headers via meta tags -->
    <meta http-equiv="X-Content-Type-Options" content="nosniff">
    <meta http-equiv="X-Frame-Options" content="DENY">
    <meta name="referrer" content="strict-origin-when-cross-origin">

    <?php include '../inc/tailwind-config.php'; ?>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .gradient-bg {
            background: linear-gradient(135deg, #f97316 0%, #22c55e 100%);
        }
        .glass-effect {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }
    </style>
</head>
<body class="min-h-screen gradient-bg flex items-center justify-center p-4">
    <!-- Background Pattern -->
    <div class="fixed inset-0 opacity-10">
        <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                    <path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="1"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#grid)"/>
        </svg>
    </div>

    <div class="relative w-full max-w-md">
        <!-- Login Card -->
        <div class="glass-effect rounded-3xl shadow-2xl overflow-hidden">
            <!-- Header -->
            <div class="px-8 pt-8 pb-6 text-center">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-gradient-to-br from-primary-500 to-secondary-500 shadow-lg shadow-primary-500/30 mb-6">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-slate-800">Admin Login</h1>
                <p class="text-slate-500 mt-2">Sign in to access the admin panel</p>
            </div>

            <!-- Form -->
            <div class="px-8 pb-8">
                <?php if ($error): ?>
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-red-600 text-sm flex items-center gap-2">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <?php echo htmlspecialchars($error); ?>
                </div>
                <?php endif; ?>

                <form method="POST" action="login.php" class="space-y-5" autocomplete="off">
                    <!-- CSRF Token -->
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken); ?>">

                    <!-- Username -->
                    <div>
                        <label for="username" class="block text-sm font-medium text-slate-700 mb-2">Username</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <input type="text" id="username" name="username" required autofocus
                                   class="w-full pl-12 pr-4 py-3 border border-slate-200 rounded-xl text-slate-800 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-colors outline-none"
                                   placeholder="Enter your username"
                                   <?php echo $lockoutSeconds !== false ? 'disabled' : ''; ?>>
                        </div>
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-700 mb-2">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                            <input type="password" id="password" name="password" required
                                   class="w-full pl-12 pr-4 py-3 border border-slate-200 rounded-xl text-slate-800 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-colors outline-none"
                                   placeholder="Enter your password"
                                   <?php echo $lockoutSeconds !== false ? 'disabled' : ''; ?>>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" name="login"
                            class="w-full py-3.5 bg-gradient-to-r from-primary-500 to-secondary-500 text-white font-semibold rounded-xl shadow-lg shadow-primary-500/30 hover:shadow-xl hover:shadow-primary-500/40 hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:translate-y-0"
                            <?php echo $lockoutSeconds !== false ? 'disabled' : ''; ?>>
                        <span>Sign In</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </button>
                </form>

                <!-- Back to Site -->
                <div class="mt-6 text-center">
                    <a href="../index.php" class="inline-flex items-center gap-2 text-slate-500 hover:text-primary-500 transition-colors text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Back to Website
                    </a>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <p class="text-center text-white/70 text-sm mt-6">
            &copy; <?php echo date("Y"); ?> YDI Admin Panel. Developed by Xpertz Dev.
        </p>
    </div>
</body>
</html>
