<?php
// Shortcode: [remote_template file="template-video-grid.php"]
add_shortcode('remote_template', function($atts) {
    $atts = shortcode_atts([
        'file' => '',
    ], $atts);

    ob_start();
    load_remote_template($atts['file']);
    return ob_get_clean();
});


[remote_template file="template-video-grid.php"]
