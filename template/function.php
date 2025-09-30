<?php
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
