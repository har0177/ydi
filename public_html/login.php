<?php
require_once 'config.php';
require_once 'inc/loader.php';
ob_start();
session_start();

// Check if already logged in
if (isset($_SESSION["std_id"]) && isset($_SESSION["std_level"])) {
    header("Location: student/index.php");
    exit();
}

// Handle logout
if (isset($_GET["do"]) && $_GET["do"] == "logout") {
    session_destroy();
    session_unset();
    header("Location: index.php");
    exit();
}

$page_title = "Login";
$show_form = "login";
$message = "";
$message_type = "";

// Determine which form to show
if (isset($_GET["id"])) {
    $do = cleanString($_GET["id"]);
    if ($do === 'register') {
        $page_title = "Register";
        $show_form = "register";
    } else if ($do === 'forget') {
        $page_title = "Forgot Password";
        $show_form = "forget";
    }
}

// Process Login
if (isset($_POST["login"])) {
    $name = cleanString($_POST["username"]);
    $password = cleanString($_POST["password"]);

    if (empty($name) || empty($password)) {
        $message = "All fields are required.";
        $message_type = "warning";
    } else {
        $db = new database();
        try {
            $db->query("SELECT * FROM users WHERE user_login = ? AND user_level = 'Student'", array($name));
            if ($db->rowCount() > 0) {
                $r = $db->fetchObject();
                $updateCallback = function($newHash) use ($db, $r) {
                    $db->query("UPDATE users SET user_password = ? WHERE user_id = ?", array($newHash, $r->user_id));
                };

                if (verifyPassword($password, $r->user_password, $updateCallback)) {
                    session_regenerate_id(true);
                    $_SESSION["std_id"] = $r->user_id;
                    $_SESSION["std_level"] = $r->user_level;
                    $_SESSION["std_name"] = $r->user_name;
                    header("Location: student/index.php");
                    exit();
                } else {
                    $message = "Invalid login credentials.";
                    $message_type = "error";
                }
            } else {
                $message = "Invalid login credentials.";
                $message_type = "error";
            }
        } catch (PDOException $e) {
            $message = "Login failed. Please try again.";
            $message_type = "error";
        }
    }
}

// Process Registration
if (isset($_POST["reg"])) {
    $uname = cleanString($_POST["username"]);
    $name = cleanString($_POST["name"]);
    $password = cleanString($_POST["password"]);
    $email = cleanString($_POST["email"]);
    $qualification = cleanString($_POST["qualification"]);
    $address = cleanString($_POST["address"]);
    $contact = cleanString($_POST["contact"]);
    $gender = cleanString($_POST["gender"]);

    if (empty($uname) || empty($password) || empty($name) || empty($email) || empty($qualification) || empty($address) || empty($gender) || empty($contact)) {
        $message = "All fields are required.";
        $message_type = "warning";
    } else {
        $db = new database();
        $db->query("SELECT * FROM users WHERE user_email = ? OR user_login = ?", array($email, $uname));
        if ($db->rowCount() > 0) {
            $message = "Email address or username already registered.";
            $message_type = "error";
        } else {
            try {
                $hashedPassword = securePasswordHash($password);
                $db->query("INSERT INTO users VALUES (null,?,?,?,?,?,?,?,?,?)",
                    array($uname, $hashedPassword, $email, $name, "Student", $qualification, $address, $contact, $gender));
                $message = "Registration successful! Redirecting to login...";
                $message_type = "success";
                header("refresh:2;login.php");
            } catch (PDOException $e) {
                $message = "Registration failed. Please try again.";
                $message_type = "error";
            }
        }
    }
}

// Process Forgot Password
if (isset($_POST["forg"])) {
    $email = cleanString($_POST["email"]);
    if (empty($email)) {
        $message = "Please enter your email address.";
        $message_type = "warning";
    } else {
        try {
            $db = new database();
            $db->query("SELECT * FROM users WHERE user_email = ? AND user_level = ?", array($email, "Student"));
            if ($db->rowCount() > 0) {
                $password = bin2hex(random_bytes(8));
                $hashedPassword = securePasswordHash($password);
                $db->query("UPDATE users SET user_password = ? WHERE user_level = ? AND user_email = ?", array($hashedPassword, "Student", $email));
                mail($email, "Reset Password", "Your new password is: " . $password . "\n\nLogin with this password and change it in your profile.");
                $message = "Check your email for your new password.";
                $message_type = "success";
            } else {
                $message = "This email address is not registered.";
                $message_type = "error";
            }
        } catch (PDOException $e) {
            $message = "Failed to reset password. Please try again.";
            $message_type = "error";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> - YDI e-Learning</title>

    <?php include 'inc/tailwind-config.php'; ?>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        .gradient-text {
            background: linear-gradient(135deg, #f97316 0%, #22c55e 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <!-- Logo -->
        <div class="text-center mb-8">
            <a href="index.php" class="inline-block">
                <h1 class="text-3xl font-bold text-white">YDI <span class="gradient-text">e-Learning</span></h1>
            </a>
            <p class="text-slate-400 mt-2">Youth Development Institute</p>
        </div>

        <!-- Card -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl overflow-hidden">
            <!-- Tabs -->
            <div class="flex border-b border-slate-200 dark:border-slate-700">
                <a href="login.php" class="flex-1 py-4 text-center font-medium transition-colors <?php echo $show_form == 'login' ? 'text-primary-500 border-b-2 border-primary-500 bg-primary-50 dark:bg-primary-900/20' : 'text-slate-500 hover:text-slate-700 dark:text-slate-400'; ?>">
                    Login
                </a>
                <a href="?id=register" class="flex-1 py-4 text-center font-medium transition-colors <?php echo $show_form == 'register' ? 'text-primary-500 border-b-2 border-primary-500 bg-primary-50 dark:bg-primary-900/20' : 'text-slate-500 hover:text-slate-700 dark:text-slate-400'; ?>">
                    Register
                </a>
                <a href="?id=forget" class="flex-1 py-4 text-center font-medium transition-colors <?php echo $show_form == 'forget' ? 'text-primary-500 border-b-2 border-primary-500 bg-primary-50 dark:bg-primary-900/20' : 'text-slate-500 hover:text-slate-700 dark:text-slate-400'; ?>">
                    Forgot
                </a>
            </div>

            <!-- Form Content -->
            <div class="p-6 lg:p-8">
                <?php if (!empty($message)) { ?>
                <div class="mb-6 p-4 rounded-xl <?php
                    echo $message_type == 'success' ? 'bg-green-100 text-green-700 border border-green-200' :
                        ($message_type == 'error' ? 'bg-red-100 text-red-700 border border-red-200' :
                        'bg-yellow-100 text-yellow-700 border border-yellow-200');
                ?>">
                    <div class="flex items-center gap-3">
                        <?php if ($message_type == 'success') { ?>
                        <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        <?php } else if ($message_type == 'error') { ?>
                        <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                        <?php } else { ?>
                        <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        <?php } ?>
                        <p class="font-medium"><?php echo $message; ?></p>
                    </div>
                </div>
                <?php } ?>

                <?php if ($show_form == 'login') { ?>
                <!-- Login Form -->
                <form method="POST" action="login.php" class="space-y-5">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Username</label>
                        <input type="text" name="username" required
                            class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all"
                            placeholder="Enter your username">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Password</label>
                        <input type="password" name="password" required
                            class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all"
                            placeholder="Enter your password">
                    </div>
                    <button type="submit" name="login"
                        class="w-full py-3 px-6 bg-gradient-to-r from-primary-500 to-secondary-500 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300">
                        Login
                    </button>
                </form>

                <?php } else if ($show_form == 'register') { ?>
                <!-- Register Form -->
                <form method="POST" action="?id=register" class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Username</label>
                            <input type="text" name="username" required
                                class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all"
                                placeholder="har0177">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Full Name</label>
                            <input type="text" name="name" required
                                class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all"
                                placeholder="Haroon Yousaf">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Email</label>
                            <input type="email" name="email" required
                                class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all"
                                placeholder="abc@xyz.com">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Password</label>
                            <input type="password" name="password" required
                                class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Qualification</label>
                            <input type="text" name="qualification" required
                                class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all"
                                placeholder="M.Sc">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Gender</label>
                            <select name="gender" required
                                class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all">
                                <?php echo list_gender(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Address</label>
                            <input type="text" name="address" required
                                class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all"
                                placeholder="Mingora Swat">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Contact</label>
                            <input type="text" name="contact" required
                                class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all"
                                placeholder="333-3333333">
                        </div>
                    </div>
                    <button type="submit" name="reg"
                        class="w-full py-3 px-6 bg-gradient-to-r from-primary-500 to-secondary-500 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300">
                        Create Account
                    </button>
                </form>

                <?php } else if ($show_form == 'forget') { ?>
                <!-- Forgot Password Form -->
                <div class="text-center mb-6">
                    <div class="w-16 h-16 bg-primary-100 dark:bg-primary-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                        </svg>
                    </div>
                    <p class="text-slate-600 dark:text-slate-400">Enter your email address and we'll send you a new password.</p>
                </div>
                <form method="POST" action="?id=forget" class="space-y-5">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Email Address</label>
                        <input type="email" name="email" required
                            class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all"
                            placeholder="Enter your email address">
                    </div>
                    <button type="submit" name="forg"
                        class="w-full py-3 px-6 bg-gradient-to-r from-primary-500 to-secondary-500 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300">
                        Reset Password
                    </button>
                </form>
                <?php } ?>
            </div>
        </div>

        <!-- Back to Home -->
        <div class="text-center mt-6">
            <a href="index.php" class="inline-flex items-center gap-2 text-slate-400 hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Home
            </a>
        </div>
    </div>
</body>
</html>
