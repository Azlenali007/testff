<?php
/**
 * PHP Built-in Server Router for N.A Fresh Fruits & Coconuts
 */
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Serve static assets from public/
$filePath = __DIR__ . '/public' . $uri;

if ($uri !== '/' && file_exists($filePath) && !is_dir($filePath)) {
    // Deliver the file with appropriate MIME type
    $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
    $mimeTypes = [
        'css' => 'text/css',
        'js' => 'application/javascript',
        'png' => 'image/png',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'webp' => 'image/webp',
        'svg' => 'image/svg+xml',
        'ico' => 'image/x-icon',
        'json' => 'application/json',
    ];
    if (isset($mimeTypes[$extension])) {
        header('Content-Type: ' . $mimeTypes[$extension]);
    }
    readfile($filePath);
    return true;
}

// Forward all other requests to the public front controller
$_SERVER['SCRIPT_NAME'] = '/index.php';
require __DIR__ . '/public/index.php';
