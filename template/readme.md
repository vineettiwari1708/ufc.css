✅ Step-by-Step Implementation (Multiple Templates Support)
1. Add to functions.php
/**
 * Load and render a remote PHP template securely via a proxy server.
 *
 * @param string $file_name Name of the remote template file (e.g., 'template-video-grid.php').
 * @param string $auth_key  Secret authorization key for your proxy.
 * @param string $remote_url Proxy server URL that serves the files.
 */
function load_remote_template($file_name, $auth_key = 'key', $remote_url = 'https://yourserver.com/serve.php') {
    // ✅ Allowed templates for security (whitelist only)
    $allowed_templates = [
        'template-video-grid.php',
        'template-services.php',
        'template-gallery.php',
        'template-about.php',
        // Add more allowed filenames as needed
    ];

    if (!in_array($file_name, $allowed_templates, true)) {
        echo "<!-- Unauthorized template requested -->";
        return;
    }

    // Build remote URL
    $url = add_query_arg([
        'key'  => $auth_key,
        'file' => $file_name,
    ], $remote_url);

    // Fetch content
    $response = wp_remote_get($url, [
        'timeout' => 10,
    ]);

    if (is_wp_error($response)) {
        error_log('Remote template fetch failed: ' . $response->get_error_message());
        echo '<!-- Error fetching template -->';
        return;
    }

    $template_code = wp_remote_retrieve_body($response);

    if (empty($template_code)) {
        echo '<!-- Empty template content -->';
        return;
    }

    // ⚠️ Dangerous: Only use if you're 100% sure of security
    try {
        eval('?>' . $template_code);
    } catch (Throwable $e) {
        error_log('Template execution failed: ' . $e->getMessage());
        echo '<!-- Template execution error -->';
    }
}

2. ✅ Use It in Any PHP Template (e.g. page.php, single.php, etc.)
<?php
// Example: Load different remote templates
load_remote_template('template-video-grid.php');
load_remote_template('template-services.php');
?>

3. ✅ Optional: Add Shortcode for Use in Post/Page

Add this below the function in functions.php:

// Shortcode: [remote_template file="template-video-grid.php"]
add_shortcode('remote_template', function($atts) {
    $atts = shortcode_atts([
        'file' => '',
    ], $atts);

    ob_start();
    load_remote_template($atts['file']);
    return ob_get_clean();
});

Usage in Gutenberg or Classic Editor:
[remote_template file="template-video-grid.php"]

🔒 Security Reminder

Only templates listed in $allowed_templates will load.

You must control the server serving the files via serve.php.

Files from GitHub or your server should be trusted and sanitized — avoid direct include, instead use eval('?>' . $code) only from trusted sources.

✅ Files You Can Add to $allowed_templates:
File Name	Purpose
template-video-grid.php	Video gallery template
template-services.php	Services section
template-about.php	About page
template-gallery.php	Image gallery

✅ Updated serve.php (Supports Multiple Templates from GitHub)
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
    'style.css'               => 'https://raw.githubusercontent.com/vineettiwari1708/qdc-css/main/style.css',
    'template-video-grid.php' => 'https://raw.githubusercontent.com/vineettiwari1708/qdc-css/main/template-video-grid.php',
    'template-services.php'   => 'https://raw.githubusercontent.com/vineettiwari1708/qdc-css/main/template-services.php',
    'template-about.php'      => 'https://raw.githubusercontent.com/vineettiwari1708/qdc-css/main/template-about.php',
    'template-gallery.php'    => 'https://raw.githubusercontent.com/vineettiwari1708/qdc-css/main/template-gallery.php',
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

🧪 Example Usage

URL format (use on client or server):

https://yourdomain.com/serve.php?key=key&file=template-video-grid.php


You can replace template-video-grid.php with:

template-services.php

template-about.php

style.css

etc.

Only files in the $allowed_files array will be served.

🔐 Security Summary
Security Feature	Status
API Key Auth	✅ Required in URL (?key=key)
Whitelist File Access	✅ Only allowed files can be loaded
CORS Headers	✅ Included
PHP Files Served Safely	✅ As raw text (not executed)
No Path Traversal	✅ basename() used
