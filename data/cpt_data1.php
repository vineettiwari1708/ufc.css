<?php
// Get properties and all fields including taxonomies as an array
function get_property_array($location = '', $keywords = '') {
    // Define the arguments for WP_Query
    $args = [
        'post_type'      => 'property',  // Post type 'property'
        'posts_per_page' => -1,          // Get all properties
        'post_status'    => 'publish',   // Only published posts
        's'              => $keywords,   // Search by keyword (title or content)
        'meta_query'     => [],          // Placeholder for meta queries
    ];

    // If location is set, add it to meta_query
    if ($location) {
        $args['meta_query'][] = [
            'key'     => 'property_location',  // Custom field (meta key)
            'value'   => $location,            // Location value to match
            'compare' => '=',                  // Exact match
        ];
    }

    // Perform the query
    $property_query = new WP_Query($args);
    
    // Initialize an empty array to hold properties
    $properties = [];
    
    if ($property_query->have_posts()) {
        while ($property_query->have_posts()) {
            $property_query->the_post();
            
            // Get property taxonomies (Location, Type, Status, etc.)
            $location_terms = wp_get_post_terms(get_the_ID(), 'property_location', ['fields' => 'names']);
            $type_terms     = wp_get_post_terms(get_the_ID(), 'property_type', ['fields' => 'names']);
            $status_terms   = wp_get_post_terms(get_the_ID(), 'property_status', ['fields' => 'names']);
            $amenities_terms = wp_get_post_terms(get_the_ID(), 'property_amenities', ['fields' => 'names']);
            $interior_terms = wp_get_post_terms(get_the_ID(), 'property_interior_details', ['fields' => 'names']);
            $smart_home_terms = wp_get_post_terms(get_the_ID(), 'property_smart_home_features', ['fields' => 'names']);
            $loan_terms = wp_get_post_terms(get_the_ID(), 'property_loan_available', ['fields' => 'names']);
            
            // Gather the data for each property post
            $property_data = [
                'ID'            => get_the_ID(),
                'title'         => get_the_title(),
                'permalink'     => get_permalink(),
                'price'         => get_post_meta(get_the_ID(), 'price', true),  // Custom field for price
                'location'      => $location_terms,  // Taxonomy for location
                'area'          => get_post_meta(get_the_ID(), 'area', true), // Custom field for area
                'bhk'           => get_post_meta(get_the_ID(), 'bhk', true),  // Custom field for bhk
                'bedrooms'      => get_post_meta(get_the_ID(), 'bedrooms', true),  // Custom field for bedrooms
                'bathrooms'     => get_post_meta(get_the_ID(), 'bathrooms', true),  // Custom field for bathrooms
                'balconies'     => get_post_meta(get_the_ID(), 'balconies', true),  // Custom field for balconies
                'floor'         => get_post_meta(get_the_ID(), 'floor', true),  // Custom field for floor
                'furnishing'    => get_post_meta(get_the_ID(), 'furnishing', true),  // Custom field for furnishing
                'facing'        => get_post_meta(get_the_ID(), 'facing', true),  // Custom field for facing
                'maintenance'   => get_post_meta(get_the_ID(), 'maintenance', true),  // Custom field for maintenance
                'ownership'     => get_post_meta(get_the_ID(), 'ownership', true),  // Custom field for ownership
                'rera_registered' => get_post_meta(get_the_ID(), 'rera_registered', true),  // Custom field for RERA registration
                'construction_status' => get_post_meta(get_the_ID(), 'construction_status', true),  // Custom field for construction status
                'age_of_property' => get_post_meta(get_the_ID(), 'age_of_property', true),  // Custom field for age of property
                'discount'      => get_post_meta(get_the_ID(), 'discount', true),  // Custom field for discount
                'latitude'      => get_post_meta(get_the_ID(), 'latitude', true),  // Custom field for latitude
                'longitude'     => get_post_meta(get_the_ID(), 'longitude', true),  // Custom field for longitude
                'neighbourhood' => get_post_meta(get_the_ID(), 'neighbourhood', true),  // Custom field for neighbourhood
                'full_address'  => get_post_meta(get_the_ID(), 'full_address', true),  // Custom field for full address
                'landmark'      => get_post_meta(get_the_ID(), 'landmark', true),  // Custom field for landmark
                'pincode'       => get_post_meta(get_the_ID(), 'pincode', true),  // Custom field for pincode
                'power_backup'  => get_post_meta(get_the_ID(), 'power_backup', true),  // Custom field for power backup
                'water_supply'  => get_post_meta(get_the_ID(), 'water_supply', true),  // Custom field for water supply
                'security'      => get_post_meta(get_the_ID(), 'security', true),  // Custom field for security
                'pet_friendly'  => get_post_meta(get_the_ID(), 'pet_friendly', true),  // Custom field for pet friendly
                'view'          => get_post_meta(get_the_ID(), 'view', true),  // Custom field for view
                'internet'      => get_post_meta(get_the_ID(), 'internet', true),  // Custom field for internet
                'sewage'        => get_post_meta(get_the_ID(), 'sewage', true),  // Custom field for sewage
                'gallery'       => get_post_meta(get_the_ID(), '_property_gallery', true),  // Custom field for gallery images
                'video'         => get_post_meta(get_the_ID(), '_property_video', true),  // Custom field for video URL
                'image'         => get_the_post_thumbnail_url(get_the_ID(), 'thumbnail'), // Featured image URL
                
                // Taxonomies (terms)
                'location_terms'       => $location_terms,  // Location taxonomy terms
                'type_terms'           => $type_terms,      // Type taxonomy terms
                'status_terms'         => $status_terms,    // Status taxonomy terms
                'amenities_terms'      => $amenities_terms, // Amenities taxonomy terms
                'interior_terms'       => $interior_terms,  // Interior Details taxonomy terms
                'smart_home_terms'     => $smart_home_terms,// Smart Home Features taxonomy terms
                'loan_terms'           => $loan_terms,      // Loan Available taxonomy terms
            ];
            
            // Add the property data to the array
            $properties[] = $property_data;
        }
    }

    // Reset post data to avoid conflicts
    wp_reset_postdata();

    return $properties; // Return the array of properties
}

// Example: Get properties for 'delhi' location and 'villa' keyword
$location = isset($_GET['location']) ? $_GET['location'] : '';
$keywords = isset($_GET['keywords']) ? $_GET['keywords'] : '';
$properties = get_property_array($location, $keywords);

// Output the properties array (just for debugging purposes)
echo '<pre>';
print_r($properties);
echo '</pre>';
?>
