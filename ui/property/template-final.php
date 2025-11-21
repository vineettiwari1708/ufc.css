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
            <select name="location" class="form-select" required>
              <option value="">Select Location</option>
              <option value="delhi" <?php selected($_GET['location'] ?? '', 'delhi'); ?>>Delhi</option>
              <option value="mumbai" <?php selected($_GET['location'] ?? '', 'mumbai'); ?>>Mumbai</option>
              <option value="lucknow" <?php selected($_GET['location'] ?? '', 'lucknow'); ?>>Lucknow</option>
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
<?php render_property_search_section('location'); ?>

<!-- You can also call it for other groupings like 'status' or 'type' -->
<?php render_property_search_section('status'); ?>
<?php render_property_search_section('type'); ?>

<?php get_footer(); ?>
