<?php
/**
 * Template Name: Custom Shop Page (With Theme Layout)
 * Description: WooCommerce shop page using [products] shortcode inside the Buildexo layout.
 */

get_header();

$data    = \buildexo\Includes\Classes\Common::instance()->data('single')->get();
$layout  = $data->get('layout');
$sidebar = $data->get('sidebar');

if (is_active_sidebar($sidebar)) {
    $layout = 'right';
} else {
    $layout = 'full';
}
$class = (!$layout || $layout == 'full') ? 'col-lg-12 col-md-12 col-sm-12' : 'col-lg-8 col-md-12 col-sm-12';
?>

<?php if ($data->get('enable_banner')) : ?>
    <?php do_action('turner_banner', $data); ?>
<?php endif; ?>

<!-- Sidebar Page Container -->
<section class="blog pt-120 pb-120">
    <div class="container">
        <div class="row">

            <?php if ($layout == 'left') {
                do_action('turner_sidebar', $data);
            } ?>

            <div class="content-side <?php echo esc_attr($class); ?>">
                <div class="blog__post-wrap">
                    <div class="custom-shop-container">

                        <h2 class="text-center mb-5">🛒 Our Products</h2>

                        <?php echo do_shortcode('[products limit="50" columns="3"]'); ?>

                    </div>
                </div>
            </div>

            <?php if ($layout == 'right') {
                $data->set('sidebar', 'default-sidebar');
                do_action('turner_sidebar', $data);
            } ?>

        </div>
    </div>
</section>

<?php get_footer(); ?>
