<?php
/* 
Template Name: Property keyword
*/

get_header();
?>

<div class="container-fluid">
  
  <div class="row d-flex g-4 ">
    
<section class="search-banner-wrapper">
  <div class="header-spacer"></div>

  <video class="bg-video" autoplay loop muted playsinline>
    <source src="http://localhost/urbanfeatconstruction/wp-content/uploads/2025/10/160033-820167238_tiny.mp4" type="video/mp4">
    Your browser does not support the video tag.
  </video>

  <div class="container h-100 d-flex flex-column justify-content-center align-items-center text-center position-relative">
    <div class="glass-blur container-fluid">
      <h1 class="mb-4 text-white">Find Your Dream Property<br>with<br>Urbanfeat Construction</h1>

    </div>
  </div>
</section>

    <!-- LEFT SIDEBAR - SEARCH FORM -->
    <div class="col-md-3 h-100 mb-4">
      <div class="p-4 bg-warning rounded shadow-sm ">
        <h4 class="mb-4 text-dark">Search Properties</h4>

        <form method="GET" action="" class="needs-validation">
          
          <!-- LOCATION -->
          <div class="mb-3">
            <label class="form-label fw-semibold fw-bold">Location</label>
            <input 
              type="text"
              name="location"
              class="form-control form-control-sm rounded-pill"
              placeholder="e.g. Mumbai, Delhi"
              value="<?php echo isset($_GET['location']) ? esc_attr($_GET['location']) : ''; ?>"
            />
          </div>

          <!-- KEYWORD -->
          <div class="mb-3">
            <label class="form-label fw-semibold fw-bold">Keyword</label>
            <input 
              type="text"
              name="keywords"
              class="form-control form-control-sm rounded-pill" 
              placeholder="e.g. garden, sea view"
              value="<?php echo isset($_GET['keywords']) ? esc_attr($_GET['keywords']) : ''; ?>"
            />
          </div>

          <button type="submit" class="btn btn-primary w-100 mt-3 cus-btn">
            Search
          </button>
        </form>
      </div>
    </div>

    <!-- RIGHT SIDE: RESULTS -->
    <div class="col-md-9 h-100 mb-5 ">
      <div class="p-4 bg-custom rounded shadow-sm bg-search-info">

        <h3 class="mb-4 text-dark">
            <?php 
              echo "Search Results";
              if (!empty($_GET['location'])) echo " in " . ucfirst($_GET['location']);
              if (!empty($_GET['keywords'])) echo " for '" . esc_html($_GET['keywords']) . "'";
            ?>
        </h3>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">

        <?php
      /** -----------------------------------------
 * SANITIZE INPUTS
 * ------------------------------------------ */
$location = sanitize_text_field($_GET['location'] ?? '');
$keywords = sanitize_text_field($_GET['keywords'] ?? '');

/** -----------------------------------------
 * META QUERY (search in multiple fields)
 * ------------------------------------------ */
$meta_query = [];

if ($keywords) {
    $meta_query = ['relation' => 'OR']; // Use OR relation for multiple fields

    $meta_fields = [
        'price', 'bhk', 'bedrooms', 'bathrooms', 'balconies', 'area',
        'floor', 'maintenance', 'ownership', 'construction_status',
        'age_of_property', 'discount', 'neighbourhood', 'full_address',
        'landmark', 'pincode'
    ];

    foreach ($meta_fields as $field) {
        $meta_query[] = [
            'key'     => $field,
            'value'   => $keywords,
            'compare' => 'LIKE' // Use LIKE to search for partial matches
        ];
    }
}

/** -----------------------------------------
 * TAX QUERY (location and keyword in amenities)
 * ------------------------------------------ */
$tax_query = [];

// Location filter
if ($location) {
    $tax_query[] = [
        'taxonomy' => 'property_location',
        'field'    => 'name',
        'terms'    => $location
    ];
}

// Keyword search in amenities taxonomy
if ($keywords) {
    $tax_query[] = [
        'taxonomy' => 'property_amenities', // Change this if you have other taxonomies
        'field'    => 'name',
        'terms'    => $keywords,
        'operator' => 'LIKE' // Allows partial match in term names
    ];
}

/** -----------------------------------------
 * WP QUERY
 * ------------------------------------------ */
$args = [
    'post_type'      => 'property',
    'posts_per_page' => -1,
    's'              => $keywords,   // WordPress title/content search
    'meta_query'     => $meta_query,
    'tax_query'      => $tax_query,
    'orderby'        => 'date', // Sort by post date (optional)
    'order'          => 'DESC'  // Optional: reverse order
];

$query = new WP_Query($args);

/** -----------------------------------------
 * DISPLAY RESULTS
 * ------------------------------------------ */
if ($query->have_posts()):
    while ($query->have_posts()): $query->the_post();

        // Fetch property details (same as your existing code)
        $property_id = get_the_ID();
        $property_title = get_the_title();
        $property_bhk = get_post_meta($property_id, 'bhk', true);
        $property_price = get_post_meta($property_id, 'price', true);
        $property_status = get_post_meta($property_id, 'status', true);
        $property_discount = get_post_meta($property_id, 'discount', true);

        // Sale flag
        $sale_flag = '';
        if ($property_status === 'Sold') {
            $sale_flag = 'SOLD';
        } elseif ($property_discount) {
            $sale_flag = $property_discount . '% OFF';
        }

        // Fetch location terms
        $property_location_terms = get_the_terms($property_id, 'property_location');
        if ($property_location_terms && !is_wp_error($property_location_terms)) {
            $locations = wp_list_pluck($property_location_terms, 'name');
            $property_location = implode(', ', $locations);
        } else {
            $property_location = 'Unknown Location';
        }

        // Fetch amenities terms (up to 3 for display)
        $property_amenities_terms = wp_get_post_terms($property_id, 'property_amenities');
        $property_amenities_terms = array_slice($property_amenities_terms, 0, 3); // Limit to first 3 amenities
        $property_amenities = wp_list_pluck($property_amenities_terms, 'name');

        // Fetch property image
        $property_image = get_the_post_thumbnail_url($property_id, 'full');

        // Create an array with the property details
        $property_data = [
            'id' => $property_id,
            'title' => $property_title,
            'bhk' => $property_bhk,
            'location' => $property_location,
            'price' => $property_price,
            'sale_flag' => $sale_flag,
            'image' => $property_image,
            'amenities' => $property_amenities,
            'status' => $property_status,
        ];

        echo '<div class="col">';
        render_property_card($property_data); // Pass the property data to the render_property_card function
        echo '</div>';

    endwhile;
else:
  
    echo "<p>No properties found.</p>";
endif;

wp_reset_postdata();
        ?>
        </div>

      </div>
    </div>

  </div>
</div>

<?php get_footer(); ?>
