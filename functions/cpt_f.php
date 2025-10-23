// Register Property Post Type
function create_property_post_type() {
    $args = [
        'labels' => [
            'name' => 'Properties', 'singular_name' => 'Property', 'menu_name' => 'Properties',
            'add_new' => 'Add New', 'add_new_item' => 'Add New Property', 'new_item' => 'New Property',
            'edit_item' => 'Edit Property', 'view_item' => 'View Property', 'all_items' => 'All Properties',
            'search_items' => 'Search Properties', 'not_found' => 'No properties found.', 'featured_image' => 'Property Image'
        ],
        'public' => true, 'supports' => ['title', 'editor', 'thumbnail', 'custom-fields'], 'has_archive' => true, 
        'rewrite' => ['slug' => 'properties'], 'show_in_rest' => false
    ];
    register_post_type('property', $args);
}
add_action('init', 'create_property_post_type');

// Register Taxonomies: Location, Type, Status
function create_property_taxonomies() {
    // List of taxonomies to register
    $taxonomies = [
        'property_location' => 'Location',
        'property_type' => 'Type',
        'property_status' => 'Status',
        'property_amenities' => 'Amenities',
        'property_interior_details' => 'Interior Details',
        'property_smart_home_features' => 'Smart Home Features',
        'property_additional_features' => 'Additional Features',
		'property_loan_available'=> 'Property Loan Available',
    ];
    
    // Loop through each taxonomy and register it
    foreach ($taxonomies as $taxonomy => $label) {
        register_taxonomy(
            $taxonomy, // Taxonomy name
            'property', // Post type (the custom post type we're associating with)
            [
                'label' => $label, // Human-readable label
                'hierarchical' => true, // Whether the taxonomy is hierarchical (like categories)
                'show_ui' => true, // Show in the admin panel
                'show_admin_column' => true, // Show as a column in the post list
                'show_in_rest' => true, // Make it available in the REST API (needed for Gutenberg)
                'rewrite' => ['slug' => sanitize_title($label)] // Create a custom slug for the taxonomy
            ]
        );
    }
}

// Hook into WordPress to register taxonomies
add_action('init', 'create_property_taxonomies');




// Register Meta Boxes
// Register Meta Boxes
function add_property_meta_boxes() {
    // Define meta boxes with ID, title, and callback function
    $meta_boxes = [
        ['property_general_info', 'General Information', 'property_general_info_html'],
    ];
    
    // Loop through each meta box and register it
    foreach ($meta_boxes as $meta_box) {
        add_meta_box(
            $meta_box[0], // Meta box ID
            $meta_box[1], // Meta box title
            $meta_box[2], // Callback function to display the content
            'property',   // Post type to show the meta box on
            'normal',     // Context (where the meta box appears)
            'high'        // Priority (whether it appears at the top or bottom)
        );
    }
}
add_action('add_meta_boxes', 'add_property_meta_boxes');

// Callback Function for Meta Boxes
function property_general_info_html($post) {
    // Add nonce for security
    wp_nonce_field('property_save_meta_box_data', 'property_meta_box_nonce');

    // Define fields and their types
    $fields = [
        'price' => 'text',
        'bhk' => 'text',
        'bedrooms' => 'number',
        'bathrooms' => 'number',
        'balconies' => 'number',
        'area' => 'text', 
        'floor' => 'text',
        'furnishing' => 'select', 
        'facing' => 'select', 
        'maintenance' => 'text',
        'ownership' => 'select', 
        'rera_registered' => 'checkbox', 
        'construction_status' => 'select', 
        'age_of_property' => 'number',
        'discount' => 'number', 
        'latitude' => 'float', 
		'longitude' => 'float',
    ];

    // Start table for layout
    echo "<table style='width: 100%; border-collapse: collapse;'>";

    // Loop through the fields and display them in table rows
    foreach ($fields as $field => $type) {
        $value = get_post_meta($post->ID, $field, true);

        // Start table row
        echo "<tr>";

        // Display the label in the first column
        echo "<td style=''><label for='$field'>" . ucfirst(str_replace('_', ' ', $field)) . ":</label></td>";

        // Display the input fields in the second column
        echo "<td style=''>";

        switch ($type) {
            case 'text':
                echo "<input type='text' name='$field' value='" . esc_attr($value) . "' style='' />";
                break;

            case 'number':
                echo "<input type='number' name='$field' value='" . esc_attr($value) . "' style='' />";
                break;
			case 'float':
                echo "<input type='number' name='$field' value='" . esc_attr($value) . "' style='' />";
                break;
            case 'select':
                $options = [];
                if ($field == 'furnishing') {
                    $options = [ 'Fully Furnished', 'Semi Furnished', 'Unfurnished'];
                } elseif ($field == 'facing') {
                    $options = ['East', 'West', 'North', 'South','North-East','North-West','South-East','South-West','Front Facing','Street Facing','Water Facing','Garden Facing','Park Facing'];
                } elseif ($field == 'ownership') {
                    $options = ['Owner', 'Renter'];
                } elseif ($field == 'construction_status') {
                    $options = ['Ready to Move', 'Under Construction', 'Pre-Launch', 'Partially Constructed', 'Completed but Pending Occupancy Certificate', 'Renovation in Progress', 'On Hold', 'For Sale'];
                }

                echo "<select name='$field' style=''>";
                foreach ($options as $option) {
                    echo "<option value='$option'" . selected($value, $option, false) . ">$option</option>";
                }
                echo "</select>";
                break;

            case 'checkbox':
                echo "<input type='checkbox' name='$field' value='1'" . checked($value, 1, false) . " />";
                break;

        }

        echo "</td>";

        // End row
        echo "</tr>";
    }

    // End table
    echo "</table>";
}



function save_property_meta_box_data($post_id) {
    // Verify nonce for security
    if (!isset($_POST['property_meta_box_nonce']) || !wp_verify_nonce($_POST['property_meta_box_nonce'], 'property_save_meta_box_data')) {
        return;
    }
    
    // Auto save check
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    // Ensure it's a 'property' post type
    if ('property' !== $_POST['post_type']) {
        return;
    }

    // Define fields to save
    $fields = [
        'price', 'bhk', 'bedrooms', 'bathrooms', 'balconies', 'area', 'floor', 
        'furnishing', 'facing', 'maintenance', 'ownership', 'rera_registered', 
        'construction_status', 'age_of_property', 'discount', 'latitude', 'longitude'
    ];

    // Loop through fields and update post meta
    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            // Handle checkbox separately
            if ($field === 'rera_registered') {
                // For checkboxes, save as 1 or 0
                update_post_meta($post_id, $field, isset($_POST[$field]) ? '1' : '0');
            } else {
                // Sanitize and save other fields
                switch ($field) {
                    case 'price':
                    case 'area':
                    case 'maintenance':
                    case 'lat':
                    case 'log':
                        // These are text fields, sanitize them as text
                        update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
                        break;

                    case 'bhk':
                    case 'bedrooms':
                    case 'bathrooms':
                    case 'balconies':
                    case 'age_of_property':
                    case 'discount':
                        // These are number fields, sanitize them as integers
                        update_post_meta($post_id, $field, intval($_POST[$field]));
                        break;

                    case 'furnishing':
                    case 'facing':
                    case 'ownership':
                    case 'construction_status':
                        // These are select fields, sanitize them as strings (assuming options are valid)
                        update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
                        break;

                    case 'floor':
                        // Assuming floor is text, sanitize it
                        update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
                        break;

                    default:
                        update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
                        break;
                }
            }
        } else {
            // If field is not set, delete it
            delete_post_meta($post_id, $field);
        }
    }

    // Save Taxonomies (terms)
    $taxonomies = [
        'property_location', 'property_type', 'property_status',
        'property_amenities', 'property_interior_details', 
        'property_smart_home_features', 'property_additional_features', 
        'property_loan_available'
    ];

    foreach ($taxonomies as $taxonomy) {
        if (isset($_POST[$taxonomy])) {
            // Sanitize terms
            $terms = array_map('sanitize_text_field', (array) $_POST[$taxonomy]);
            wp_set_post_terms($post_id, $terms, $taxonomy);
        } else {
            // If taxonomy is not set, remove terms
            wp_set_post_terms($post_id, [], $taxonomy);
        }
    }
}
add_action('save_post', 'save_property_meta_box_data');
