<?php
/**
 * Template Name: Video Gallery Mobile(With Theme Layout)
 * Description: Responsive 3‑column video gallery using hardcoded links, within Buildexo layout (with banner/sidebar support).
 */

get_header();

$data = \buildexo\Includes\Classes\Common::instance()->data('single')->get();
$layout = $data->get('layout');
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

<section class="blog pt-120 pb-120">
    <div class="container">
        <div class="row">
            <?php if ($data->get('layout') == 'left') {
                do_action('turner_sidebar', $data);
            } ?>
            <div class="content-side <?php echo esc_attr($class); ?>">
                <div class="blog__post-wrap">
                    <div class="thm-unit-test">

                        <h2 class="text-center mb-5">🎬 Featured Video Gallery</h2>

                        <?php
                        $youtube_videos = [
                            'https://www.youtube.com/shorts/a1-T2Pj_CDg',
                            'https://www.youtube.com/shorts/E1FUGWVInuM',
                            'https://www.youtube.com/shorts/wrIgzJTT8I0'
                        ];

                        $instagram_videos = [
                            'https://www.instagram.com/p/DON_puQDDHm/',
                            'https://www.instagram.com/p/DOYVKpLDKOa/',
                            'https://www.instagram.com/p/DN-rMi7jGuF/'
                        ];

                        $all_videos = array_merge($youtube_videos, $instagram_videos);
                        ?>

                        <div class="video-grid">
                            <?php foreach ($all_videos as $video_url): ?>
                                <div class="video-card-wrapper">
                                    <?php if (strpos($video_url, 'youtube.com/shorts/') !== false): ?>
                                        <iframe
                                            src="<?php echo str_replace('/shorts/', '/embed/', esc_url($video_url)); ?>"
                                            frameborder="0"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                            allowfullscreen>
                                        </iframe>
                                    <?php elseif (strpos($video_url, 'instagram.com') !== false): ?>
                                        <div class="instagram-embed-wrapper">
                                            <blockquote
                                                class="instagram-media"
                                                data-instgrm-permalink="<?php echo esc_url($video_url); ?>"
                                                data-instgrm-version="14"
                                                style="margin:0; padding:0; border:0;">
                                            </blockquote>
                                        </div>
                                    <?php endif; ?>

                                    <div class="floating-buttons">
                                        <a href="https://upgrade.urbanfeatconstruction.com/contact-2/" class="floating-btn red-btn" title="Enquiry">
                                            <!-- svg code omitted for brevity -->
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><path d="M112 128C85.5 128 64 149.5 64 176C64 191.1 71.1 205.3 83.2 214.4L291.2 370.4C308.3 383.2 331.7 383.2 348.8 370.4L556.8 214.4C568.9 205.3 576 191.1 576 176C576 149.5 554.5 128 528 128L112 128zM64 260L64 448C64 483.3 92.7 512 128 512L512 512C547.3 512 576 483.3 576 448L576 260L377.6 408.8C343.5 434.4 296.5 434.4 262.4 408.8L64 260z"/></svg>
                                        </a>
                                        <a href="https://wa.me/917239001002" target="_blank" class="floating-btn green-btn" title="WhatsApp">
                                            <!-- svg code omitted -->
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><path d="M224.2 89C216.3 70.1 195.7 60.1 176.1 65.4L170.6 66.9C106 84.5 50.8 147.1 66.9 223.3C104 398.3 241.7 536 416.7 573.1C493 589.3 555.5 534 573.1 469.4L574.6 463.9C580 444.2 569.9 423.6 551.1 415.8L453.8 375.3C437.3 368.4 418.2 373.2 406.8 387.1L368.2 434.3C297.9 399.4 241.3 341 208.8 269.3L253 233.3C266.9 222 271.6 202.9 264.8 186.3L224.2 89z"/></svg>
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <style>
                        /* Core Grid & Card Styles */
                        .video-grid {
                            display: grid;
                            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                            gap: 40px;
                            margin-top: 40px;
                        }

                        .video-card-wrapper {
                            position: relative;
                            width: 100%;
                            max-width: 400px;
                            height: 450px;
                            margin: 0 auto;
                            border-radius: 20px;
                            overflow: hidden;
                            backdrop-filter: blur(10px);
                            background: rgba(255, 255, 255, 0.06);
                            border: 1px solid rgba(255, 255, 255, 0.2);
                            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
                            transition: transform 0.3s ease, box-shadow 0.3s ease;
                            display: flex;
                            justify-content: center;
                            align-items: center;
                        }

                        .video-card-wrapper:hover {
                            transform: translateY(-10px);
                            box-shadow: 0 16px 32px rgba(0, 0, 0, 0.3);
                        }

                        /* YouTube iframe */
                        .video-card-wrapper iframe {
                            width: 100%;
                            height: 100%;
                            border: none;
                            display: block;
                        }

                        /* Instagram Embed Overrides */
                        .instagram-embed-wrapper {
                            position: absolute;
                            top: 0;
                            left: 0;
                            width: 100% !important;
                            height: 100% !important;
                            overflow: hidden;
                            display: flex;
                            justify-content: center;
                            align-items: center;
                            padding: 0 !important;
                            margin: 0 !important;
                        }

                        .instagram-embed-wrapper blockquote.instagram-media {
                            width: 100% !important;
                            max-width: 100% !important;
                            height: 100% !important;
                            max-height: 100% !important;
                            margin: 0 !important;
                            padding: 0 !important;
                            border: 0 !important;
                            overflow: hidden !important;
                        }

                        .instagram-embed-wrapper blockquote.instagram-media > div {
                            margin: 0 !important;
                            padding: 0 !important;
                            max-width: 100% !important;
                        }

                        .instagram-embed-wrapper blockquote.instagram-media iframe {
                            width: 100% !important;
                            height: 100% !important;
                        }
                       

                        /* Floating Buttons */
                        .floating-buttons {
                            position: absolute;
                            bottom: 20px;
                            left: 0;
                            width: 100%;
                            display: flex;
                            justify-content: center;
                            gap: 20px;
                            opacity: 0;
                            pointer-events: none;
                            transition: opacity 0.3s ease;
                            z-index: 2;
                        }

                        .video-card-wrapper:hover .floating-buttons {
                            opacity: 1;
                            pointer-events: auto;
                        }

                        .floating-btn {
                            width: 52px;
                            height: 52px;
                            border-radius: 50%;
                            background-color: #333;
                            color: white;
                            display: flex;
                            justify-content: center;
                            align-items: center;
                            text-decoration: none;
                            transition: background-color 0.3s ease;
                            z-index: 3;
                        }

                        .floating-btn svg {
                            width: 24px;
                            height: 24px;
                            fill: white;
                        }

                        .red-btn {
                            background-color: #FF0000;
                        }
                        .red-btn:hover {
                            background-color: #cc0000;
                        }

                        .green-btn {
                            background-color: #33cc33;
                        }
                        .green-btn:hover {
                            background-color: #28a428;
                        }

                        @media (max-width: 480px) {
                            .video-card-wrapper {
                                height: 400px;
                            }
                            .floating-btn {
                                width: 44px;
                                height: 44px;
                            }
                            .floating-btn svg {
                                width: 20px;
                                height: 20px;
                            }
                        }

                        </style>

                    </div>
                </div>
            </div>
            <?php
            if ($layout == 'right') {
                $data->set('sidebar', 'default-sidebar');
                do_action('turner_sidebar', $data);
            }
            ?>
        </div>
    </div>
</section>

<!-- Instagram embed script -->
<script async src="//www.instagram.com/embed.js"></script>
<script>
    window.addEventListener('load', function () {
        if (window.instgrm) {
            window.instgrm.Embeds.process();
        }
    });
</script>

<?php get_footer(); ?>
