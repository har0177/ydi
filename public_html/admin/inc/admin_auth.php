<?php
/**
 * Lightweight admin auth check — use for headless endpoints (CSV export, AJAX, etc.)
 * that need session security without the full HTML admin shell.
 *
 * For pages with admin UI, continue using require 'header.php' which includes this.
 */
require_once dirname(__DIR__, 2) . '/config.php';
require_once dirname(__DIR__, 2) . '/inc/loader.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!defined('SESSION_TIMEOUT')) {
    define('SESSION_TIMEOUT', 3600);
}

// Check if user is logged in
if (!isset($_SESSION["user_id"]) || !isset($_SESSION["user_level"])) {
    header("Location: login.php");
    exit();
}

// Session timeout check
if (isset($_SESSION['last_activity'])) {
    if (time() - $_SESSION['last_activity'] > SESSION_TIMEOUT) {
        session_unset();
        session_destroy();
        header("Location: login.php?expired=1");
        exit();
    }
}
$_SESSION['last_activity'] = time();

// Regenerate session ID periodically
if (!isset($_SESSION['session_created'])) {
    $_SESSION['session_created'] = time();
} else if (time() - $_SESSION['session_created'] > 1800) {
    session_regenerate_id(true);
    $_SESSION['session_created'] = time();
}

// Security headers
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: DENY");
header("X-XSS-Protection: 1; mode=block");
header("Referrer-Policy: strict-origin-when-cross-origin");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
