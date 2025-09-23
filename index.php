function inject_global_stylesheet() {
    wp_enqueue_style(
        'custom-global-style', // Handle (unique name)
        'https://domain.com/doain.php/?key=key', // Your stylesheet URL
        array(),              // Dependencies
        null                  // Version (null = no ?ver= param)
    );
}
add_action('wp_enqueue_scripts', 'inject_global_stylesheet');
