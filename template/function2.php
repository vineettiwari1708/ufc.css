function load_remote_template($file) {
    $key = 'key'; // Same as above
    $url = 'https://yourdomain.com/serve.php?key=' . $key . '&file=' . urlencode($file);

    $response = wp_remote_get($url);
    if (!is_wp_error($response)) {
        $template_code = wp_remote_retrieve_body($response);
        eval('?>' . $template_code); // ⚠️ Only use with trusted files
    } else {
        echo 'Template load failed.';
    }
}
