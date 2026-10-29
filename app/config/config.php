<?php
/**
 * Global Application Configuration
 * N.A Fresh Fruits & Coconuts
 */

// Timezone (Indian Standard Time matching the business context)
date_default_timezone_set('Asia/Kolkata');

// Error reporting for production environment
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
ini_set('display_errors', '0');
ini_set('log_errors', '1');
ini_set('error_log', __DIR__ . '/../../storage/logs/php_error.log');

// Environment settings
if (!defined('APP_NAME')) define('APP_NAME', 'N.A Fresh Fruits & Coconuts');
if (!defined('APP_URL')) define('APP_URL', '');
if (!defined('CURRENCY_SYMBOL')) define('CURRENCY_SYMBOL', '₹');

// Database configuration
if (!defined('DB_HOST')) define('DB_HOST', getenv('DB_HOST') ?: '127.0.0.1');
if (!defined('DB_PORT')) define('DB_PORT', getenv('DB_PORT') ?: '3306');
if (!defined('DB_NAME')) define('DB_NAME', getenv('DB_NAME') ?: 'na_coconuts');
if (!defined('DB_USER')) define('DB_USER', getenv('DB_USER') ?: 'na_user');
if (!defined('DB_PASS')) define('DB_PASS', getenv('DB_PASS') ?: 'na_pass123');

// Security settings
define('SESSION_LIFETIME', 86400 * 7); // 7 days
define('CSRF_TOKEN_KEY', '_csrf_token');
define('UPLOAD_DIR', __DIR__ . '/../../public/assets/uploads/');
define('MAX_UPLOAD_SIZE', 5 * 1024 * 1024); // 5 MB
