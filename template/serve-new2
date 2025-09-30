<?php
// 🔐 Secret Key (change this to something secure!)
$authKey = 'key';

// 🔐 Auth Check
if (!isset($_GET['key']) || $_GET['key'] !== $authKey) {
    http_response_code(403);
    exit('/* Forbidden: Invalid key */');
}

// 🌐 CORS Headers (optional but good for browser use)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

// 🧼 Get and sanitize the requested file
$file = basename($_GET['file'] ?? '');

// ✅ Whitelisted files (add more here)
$allowed_files = [
    'template-video-grid.php' => 'https://raw.githubusercontent.com/vineettiwari1708/qdc-css/main/template-video-grid.php',
    'template-services.php'   => 'https://raw.githubusercontent.com/vineettiwari1708/qdc-css/main/template-services.php',
    'template-gallery.php'    => 'https://raw.githubusercontent.com/vineettiwari1708/qdc-css/main/template-gallery.php',
    'style.css'               => 'https://raw.githubusercontent.com/vineettiwari1708/qdc-css/main/style.css',
    // Add more files here as needed
];

// ❌ File not in whitelist
if (!array_key_exists($file, $allowed_files)) {
    http_response_code(404);
    exit('/* File not found or not allowed */');
}

// 📄 Set appropriate content-type
$ext = pathinfo($file, PATHINFO_EXTENSION);
switch ($ext) {
    case 'css':
        header('Content-Type: text/css');
        break;
    case 'js':
        header('Content-Type: application/javascript');
        break;
    case 'php':
        header('Content-Type: text/plain'); // Safe: don't execute remotely
        break;
    case 'html':
        header('Content-Type: text/html');
        break;
    default:
        header('Content-Type: application/octet-stream');
        break;
}

// 🧲 Use cURL to fetch the GitHub file (more reliable than file_get_contents)
function fetch_remote_file($url) {
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_USERAGENT => 'PHP-Remote-Template-Proxy'
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);

    if ($httpCode !== 200 || $response === false) {
        error_log("❌ cURL Error: $error | HTTP Status: $httpCode");
        return false;
    }

    return $response;
}

// 📥 Fetch and return the content
$content = fetch_remote_file($allowed_files[$file]);

if ($content === false) {
    http_response_code(500);
    exit('/* Error loading file */');
}

echo $content;
