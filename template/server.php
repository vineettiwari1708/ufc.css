<?php
// 🔐 Secret Auth Key
$authKey = 'key'; // Replace with your secure key

// 🔐 Validate Auth Key
if (!isset($_GET['key']) || $_GET['key'] !== $authKey) {
    http_response_code(403);
    exit('/* Forbidden: Invalid key */');
}

// 🌐 CORS Headers (if needed for frontend requests)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

// 📁 Whitelisted Templates from GitHub (Add as many as you need)
$allowed_files = [
    'style.css'               => 'https://raw.githubusercontent.com/vineettiwari1708/ufc-css/main/style.css',
    'template-video-grid.php' => 'https://raw.githubusercontent.com/vineettiwari1708/ufc-css/main/template-video-grid.php',
    'template-services.php'   => 'https://raw.githubusercontent.com/vineettiwari1708/ufc-css/main/template-services.php',
    'template-about.php'      => 'https://raw.githubusercontent.com/vineettiwari1708/ufc-css/main/template-about.php',
    'template-gallery.php'    => 'https://raw.githubusercontent.com/vineettiwari1708/ufc-css/main/template-gallery.php',
    // Add more here as needed
];

// 🧼 Get requested file from the query parameter
$file = $_GET['file'] ?? '';
$file = basename($file); // Remove path traversal attempts

// ✅ Check if file is allowed
if (!array_key_exists($file, $allowed_files)) {
    http_response_code(404);
    exit('/* File not found or not allowed */');
}

// 📄 Set Correct Content-Type Based on Extension
$extension = pathinfo($file, PATHINFO_EXTENSION);
switch ($extension) {
    case 'css':
        header('Content-Type: text/css');
        break;
    case 'js':
        header('Content-Type: application/javascript');
        break;
    case 'php':
        header('Content-Type: text/plain'); // Return raw PHP, DO NOT execute
        break;
    case 'html':
        header('Content-Type: text/html');
        break;
    default:
        header('Content-Type: application/octet-stream');
        break;
}

// 📥 Fetch and return the file content from GitHub
$content = @file_get_contents($allowed_files[$file]);

if ($content === false) {
    http_response_code(500);
    exit('/* Error fetching file from GitHub */');
}

// ✅ Output the file content
echo $content;
