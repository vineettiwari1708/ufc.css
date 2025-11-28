<?php

/**
 * Template Name: Property Search Page
 */
get_header();
?>

<section class="search-banner-wrapper">
  <div class="header-spacer"></div>

  <video class="bg-video" autoplay loop muted playsinline>
    <source src="http://localhost/urbanfeatconstruction/wp-content/uploads/2025/10/160033-820167238_tiny.mp4" type="video/mp4">
    Your browser does not support the video tag.
  </video>

  <div class="container h-100 d-flex flex-column justify-content-center align-items-center text-center position-relative">
    <div class="glass-blur container-fluid">
      <h1 class="mb-4 text-white">Find Your Dream Property</h1>

      <div class="form-wrapper">
        <form method="get" class="row g-3 align-self">
          <div class="col-md-5">
            <select name="location" class="form-select" id="location" required>
              <option value="">Select Location</option>
              <option value="agra" <?php selected($_GET['location'] ?? '', 'agra'); ?>>Agra</option>
              <option value="aligarh" <?php selected($_GET['location'] ?? '', 'aligarh'); ?>>Aligarh</option>
              <option value="ayodhya" <?php selected($_GET['location'] ?? '', 'ayodhya'); ?>>Ayodhya</option>
              <option value="bareilly" <?php selected($_GET['location'] ?? '', 'bareilly'); ?>>Bareilly</option>
              <option value="faizabad" <?php selected($_GET['location'] ?? '', 'faizabad'); ?>>Faizabad</option>
              <option value="firozabad" <?php selected($_GET['location'] ?? '', 'firozabad'); ?>>Firozabad</option>
              <option value="ghaziabad" <?php selected($_GET['location'] ?? '', 'ghaziabad'); ?>>Ghaziabad</option>
              <option value="jhansi" <?php selected($_GET['location'] ?? '', 'jhansi'); ?>>Jhansi</option>
              <option value="kanpur" <?php selected($_GET['location'] ?? '', 'kanpur'); ?>>Kanpur</option>
              <option value="lucknow" <?php selected($_GET['location'] ?? '', 'lucknow'); ?>>Lucknow</option>
              <option value="mathura" <?php selected($_GET['location'] ?? '', 'mathura'); ?>>Mathura</option>
              <option value="meerut" <?php selected($_GET['location'] ?? '', 'meerut'); ?>>Meerut</option>
              <option value="prayagraj" <?php selected($_GET['location'] ?? '', 'prayagraj'); ?>>Prayagraj</option>
              <option value="sultanpur" <?php selected($_GET['location'] ?? '', 'sultanpur'); ?>>Sultanpur</option>
              <option value="varanasi" <?php selected($_GET['location'] ?? '', 'varanasi'); ?>>Varanasi</option>
            </select>
          </div>
          <div class="col-md-5">
            <input
              type="text"
              name="keywords"
              class="form-control"
              placeholder="Enter keywords (e.g., villa, 3BHK)"
              value="<?php echo esc_attr($_GET['keywords'] ?? ''); ?>" />
          </div>
          <div class="col-md-2">
            <button type="submit" class="btn btn-primary cus-btn">Search</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>

<!-- Grouped by Location Section -->
<?php
$search_applied = !empty($_GET['location']) || !empty($_GET['keywords']);

if ($search_applied) {
    // Show ONLY the location results when searching
    render_property_search_section('location');

} else {
    // Show all grouped sections when NOT searching
    render_property_search_section('location');
    render_property_search_section('status');
    render_property_search_section('type');
}
?>


<?php get_footer(); ?>
