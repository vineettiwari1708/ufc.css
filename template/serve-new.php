<?php
$authKey = 'key'; // Your secret key

// ✅ Validate the key
if (!isset($_GET['key']) || $_GET['key'] !== $authKey) {
    http_response_code(403);
    exit('/* Forbidden: Invalid key */');
}

// ✅ CORS headers (optional)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

// ✅ Sanitize filename
$file = basename($_GET['file'] ?? '');

// ✅ Whitelisted files
$allowed_files = [
    'template-video-grid.php' => 'https://raw.githubusercontent.com/vineettiwari1708/qdc-css/main/template-video-grid.php',
    'template-services.php'   => 'https://raw.githubusercontent.com/vineettiwari1708/qdc-css/main/template-services.php',
    'style.css'               => 'https://raw.githubusercontent.com/vineettiwari1708/qdc-css/main/style.css',
];

// ✅ Debug logs (optional - check PHP error log)
error_log('Requested file: ' . $file);
error_log('Allowed files: ' . implode(', ', array_keys($allowed_files)));

// ✅ Check whitelist
if (!array_key_exists($file, $allowed_files)) {
    http_response_code(404);
    exit('/* File not found or not allowed */');
}

// ✅ Set content type
$extension = pathinfo($file, PATHINFO_EXTENSION);
switch ($extension) {
    case 'css':
        header('Content-Type: text/css');
        break;
    case 'js':
        header('Content-Type: application/javascript');
        break;
    case 'php':
        header('Content-Type: text/plain');
        break;
    case 'html':
        header('Content-Type: text/html');
        break;
    default:
        header('Content-Type: application/octet-stream');
        break;
}

// ✅ Fetch file from GitHub
$content = @file_get_contents($allowed_files[$file]);

if ($content === false) {
    http_response_code(500);
    exit('/* Error loading file */');
}

// ✅ Output content
echo $content;
