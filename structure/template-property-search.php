<?php

/**
 * Template Name: Property Search Page
 */

get_header();

global $wp_query;
$data  = \buildexo\Includes\Classes\Common::instance()->data('archive')->get();
$layout = $data->get('layout');
$sidebar = $data->get('sidebar');
$layout = ($layout) ? $layout : 'right';
$sidebar = ($sidebar) ? $sidebar : 'default-sidebar';
if (is_active_sidebar($sidebar)) {
    $layout = 'right';
} else {
    $layout = 'full';
}
$class = (!$layout || $layout == 'full') ? 'col-lg-12 col-md-12 col-sm-12' : 'col-lg-8 col-md-12 col-sm-12';
if (class_exists('\Elementor\Plugin') and $data->get('tpl-type') == 'e' and $data->get('tpl-elementor')) {
    echo Elementor\Plugin::instance()->frontend->get_builder_content_for_display($data->get('tpl-elementor'));
} else {
?>
    <?php if ($data->get('enable_banner')) : ?>
        <?php do_action('turner_banner', $data); ?>
    <?php else: ?>

        <!-- breadcrumb start -->
        
        <!-- breadcrumb end -->

    <?php endif; ?>

    <main class="site-main">

        <div class="container py-5">
            <!-- 🧠 Output the actual page content (editable from WP admin) -->
            <?php
            while (have_posts()) : the_post();
                the_content(); // <- This gets the page builder or editor content
            endwhile;
            ?>

            <!-- 🔎 Your Search Form (or you can build this with ACF blocks too) -->
            <form method="get" action="<?php echo esc_url(get_permalink()); ?>" class="mb-5 pt-5" style="backgrond-color:orange;">
                <div class="row g-5">
                    <div class="col-md-4"> <select name="location" class="form-select">
                            <option value="">All Locations</option>
                            <option value="delhi">Delhi</option>
                            <option value="mumbai">Mumbai</option>
                            <option value="mumbai">Lucknow</option> <!-- Add dynamic options here -->
                        </select> </div>
                    <div class="col-md-5"> <select name="type" class="form-select">
                            <option value="">All Types</option>
                            <option value="villa">Villa</option>
                            <option value="apartment">Apartment</option>
                            <option value="apartment">Residential</option>
                        </select> </div>
                    <div class="col-md-3"> <button type="submit" class="btn btn-primary w-100 h-75">Search</button> </div>
                </div>
            </form>


            <!-- 🏡 Property Query (filtered by GET params) -->
            <?php
            $location = sanitize_text_field($_GET['location'] ?? '');
            $type = sanitize_text_field($_GET['type'] ?? '');

            $args = array(
                'post_type' => 'property',
                'posts_per_page' => 10,
            );

            // Build meta_query based on filters
            $meta_query = [];

            if (!empty($location)) {
                $meta_query[] = array(
                    'key' => 'location',
                    'value' => $location,
                    'compare' => '=',
                );
            }

            if (!empty($type)) {
                $meta_query[] = array(
                    'key' => 'type',
                    'value' => $type,
                    'compare' => '=',
                );
            }

            if (!empty($meta_query)) {
                $args['meta_query'] = $meta_query;
            }

            $query = new WP_Query($args);
            ?>

            <?php if ($query->have_posts()) : ?>
                <div class="row pt-3">
                    <?php while ($query->have_posts()) : $query->the_post(); ?>
                        <div class="col-md-3 mb-4">
                            <div class="card">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('medium', ['class' => 'card-img-top']); ?>
                                <?php endif; ?>
                                <div class="card-body">
                                    <h5 class="card-title"><?php the_title(); ?></h5>
                                    <a href="<?php the_permalink(); ?>" class="btn btn-sm btn-outline-primary">View Details</a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else : ?>
                <p>No properties found.</p>
            <?php endif; ?>

            <?php wp_reset_postdata(); ?>
        </div>

    </main>
<?php
}
get_footer();
