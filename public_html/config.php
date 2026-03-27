<?php
/**
 * Configuration File for YDI Public Website
 *
 * @version 2.0 - Security Enhanced
 * @php 8.3 compatible
 */

// Start session for CSRF protection (before any output)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load environment configuration
require_once __DIR__ . '/inc/env_loader.php';

// DATABASE CONFIGURATION (loaded from .env)
define("DBHOST", env('DB_HOST', 'localhost'));
define("DBUNAME", env('DB_USERNAME'));
define("DBPASS", env('DB_PASSWORD'));
define("DBNAME", env('DB_NAME_PUBLIC', 'ydiedu_ydi'));

// Application paths
define("ABSPATH", dirname(__FILE__) . "/");

// Security settings
define("APP_ENV", env('APP_ENV', 'production'));
define("APP_DEBUG", env('APP_DEBUG', 'false') === 'true');

// Error display based on environment
if (!APP_DEBUG) {
    ini_set('display_errors', '0');
    ini_set('log_errors', '1');
    error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
} else {
    ini_set('display_errors', '1');
    error_reporting(E_ALL);
}
