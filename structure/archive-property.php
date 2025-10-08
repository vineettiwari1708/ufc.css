<?php
/**
 * Archive Template: Property Archive (with Theme Layout)
 *
 * This will handle listing/searching properties and use your theme's header, footer, sidebars, banner, etc.
 */

get_header();

$data = \buildexo\Includes\Classes\Common::instance()->data('archive')->get();
$layout = $data->get('layout');
$sidebar = $data->get('sidebar');

// If sidebar is active, force layout to “right” (or whatever your theme logic expects)
if (is_active_sidebar($sidebar)) {
    $layout = 'right';
} else {
    $layout = 'full';
}

// Determine CSS class for content area
$class = (!$layout || $layout == 'full')
    ? 'col-lg-12 col-md-12 col-sm-12'
    : 'col-lg-8 col-md-12 col-sm-12';
?>

<?php if ($data->get('enable_banner')) : ?>
    <?php do_action('turner_banner', $data); ?>
<?php endif; ?>

<section class="property-archive pt-120 pb-120">
    <div class="container">
        <div class="row">
            <?php if ($layout == 'left') : ?>
                <?php do_action('turner_sidebar', $data); ?>
            <?php endif; ?>

            <div class="content-side <?php echo esc_attr($class); ?>">
                <div class="property-listing-wrap">

                    <h2 class="mb-4">Browse Properties</h2>

                    <!-- 🔍 Search / Filter Form -->
                    <form method="get" action="<?php echo esc_url(get_post_type_archive_link('property')); ?>" class="mb-5">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="location_filter">Location</label>
                                <select id="location_filter" name="location" class="form-select">
                                    <option value="">All Locations</option>
                                    <?php
                                    $locations = get_terms([
                                        'taxonomy' => 'property_location',
                                        'hide_empty' => false
                                    ]);
                                    foreach ($locations as $loc) {
                                        $sel = (isset($_GET['location']) && $_GET['location'] == $loc->slug) ? 'selected' : '';
                                        echo '<option value="' . esc_attr($loc->slug) . '" ' . esc_attr($sel) . '>' . esc_html($loc->name) . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label for="keyword_search">Keyword</label>
                                <input id="keyword_search" type="text" name="s" class="form-control"
                                    placeholder="Search properties…" value="<?php echo esc_attr(get_search_query()); ?>">
                            </div>

                            <div class="col-md-4 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary w-100">Search</button>
                            </div>
                        </div>
                    </form>

                    <!-- 📦 Properties Loop -->
                    <div class="row">
                        <?php
                        $paged = get_query_var('paged') ? get_query_var('paged') : 1;

                        $args = [
                            'post_type' => 'property',
                            'posts_per_page' => 9,
                            'paged' => $paged,
                            'post_status' => 'publish',
                        ];

                        // Location filter
                        if (!empty($_GET['location'])) {
                            $args['tax_query'][] = [
                                'taxonomy' => 'property_location',
                                'field'    => 'slug',
                                'terms'    => sanitize_text_field($_GET['location']),
                            ];
                        }

                        // Keyword search
                        if (!empty($_GET['s'])) {
                            $args['s'] = sanitize_text_field($_GET['s']);
                        }

                        $prop_query = new WP_Query($args);

                        if ($prop_query->have_posts()) :
                            while ($prop_query->have_posts()) : $prop_query->the_post(); ?>
                                <div class="col-md-4 mb-4">
                                    <div class="property-card h-100 border p-3">
                                        <a href="<?php the_permalink(); ?>" class="text-decoration-none">
                                            <?php if (has_post_thumbnail()) : ?>
                                                <div class="mb-3">
                                                    <?php the_post_thumbnail('medium_large', ['class' => 'img-fluid']); ?>
                                                </div>
                                            <?php endif; ?>
                                            <h5 class="mb-2"><?php the_title(); ?></h5>
                                            <p><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>
                                            <span class="btn btn-sm btn-outline-primary mt-2">View Details</span>
                                        </a>
                                    </div>
                                </div>
                            <?php endwhile; ?>

                            <!-- Pagination -->
                            <div class="col-12 mt-4">
                                <?php
                                echo paginate_links([
                                    'total' => $prop_query->max_num_pages,
                                    'prev_text' => '&laquo;',
                                    'next_text' => '&raquo;'
                                ]);
                                ?>
                            </div>
                        <?php else : ?>
                            <div class="col-12">
                                <p>No properties found.</p>
                            </div>
                        <?php endif;

                        wp_reset_postdata();
                        ?>
                    </div>

                </div> <!-- /.property-listing-wrap -->
            </div>

            <?php if ($layout == 'right') : ?>
                <?php
                // Optionally set the sidebar name if your theme expects it
                $data->set('sidebar', 'default-sidebar');
                do_action('turner_sidebar', $data);
                ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>
