<?php

/**
 * Template Name: Single Property
 */

get_header();


?>

<html>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<div class="container-fluid">
  <div class="row d-flex g-4">
    
    <!-- Search Banner -->
    <section class="search-banner-wrapper">
      <div class="header-spacer"></div>
      <video class="bg-video" autoplay loop muted playsinline>
        <source src="http://localhost/urbanfeatconstruction/wp-content/uploads/2025/10/160033-820167238_tiny.mp4" type="video/mp4">
        Your browser does not support the video tag.
      </video>
      <div class="container h-100 d-flex flex-column justify-content-center align-items-center text-center position-relative">
        <div class="glass-blur container-fluid">
          <h1 class="mb-4 text-white"><?php the_title(); ?></h1>
        </div>
      </div>
    </section>
    </div>
    </div>

<body class="bg-light text-dark py-4 ">

    <div class="container mt-5">
        <article class="property-details">
            <header class="row g-4">
                <!-- Media Gallery -->
                <div class="col-md-6">
                    <div class="bg-white p-3 rounded shadow-sm">
                        <div class="media" style="position: relative; width: 100%; height: 400px; overflow: hidden;">
                            <div class="main-media-viewer mb-3" id="mainViewer" style="width: 100%; height: 100%; overflow: hidden;">
                               
                                <?php
                                // Get the gallery data (images)
                                $media = get_post_meta(get_the_ID(), '_property_gallery', true);

                                // Check if gallery exists and is not empty
                                if ($media) {
                                    // If it's a single string, convert it to an array
                                    if (!is_array($media)) {
                                        $media = explode(',', $media);
                                    }

                                    // Display the first media (which should be an image)
                                    $first_media = esc_url($media[0]);
                                    echo '<img src="' . $first_media . '" alt="Main Media" id="mainMediaElement" style="width: 100%; height: 400px; object-fit: cover;" />';
                                }
                                ?>
                            </div>

                            <!-- Thumbnail navigation buttons (optional) -->
                            <div class="d-flex justify-content-between mb-3" style="position: absolute; width: 100%; top: 50%; transform: translateY(-50%);">
                                <button class="rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;" onclick="changeMedia(-1)">
                                    <i class="bi-caret-left-fill"></i>
                                </button>
                                <button class="rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px; align-self: center;" onclick="changeMedia(1)">
                                    <i class="bi-caret-right-fill"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Add gap between the main image and thumbnails -->
                        <div class="d-flex flex-wrap gap-2 justify-content-center mt-2" id="thumbnailContainer">
                            <?php
                            // Display image thumbnails only
                            if ($media) {
                                foreach ($media as $index => $item) {
                                    // Display Image Thumbnail
                                    echo '<div class="thumbnail" data-index="' . esc_attr($index) . '" data-src="' . esc_url($item) . '" style="width: 75px; height: 75px; overflow: hidden; margin: 5px;">';
                                    echo '<img src="' . esc_url($item) . '" alt="Thumbnail" style="width: 100%; height: 100%; object-fit: cover;" />';
                                    echo '</div>';
                                }
                            }
                            ?>
                        </div>

                    </div>
                </div>


                <!-- Property Info -->
                <div class="col-md-6">
                    
                    <section class="bg-white p-4 rounded shadow-sm">
                        
                        <h1 class="h4 text-dark mb-1"><?php the_title(); ?></h1>
                        <div class="fs-5 fw-bold text-success mb-2"><?php echo get_post_meta(get_the_ID(), 'price', true); ?></div>
                        <div class="fs-5 fw-bold text-success mb-2"><?php echo get_post_meta(get_the_ID(), 'description', true); ?></div>
                        <span class="badge bg-primary mb-3"><?php echo get_post_meta(get_the_ID(), 'property_type', true); ?></span>

                        <ul class="list-unstyled small">
                            <li class="d-flex justify-content-between border-bottom py-1">
                                <span class="fw-bold text-muted">Bedrooms:</span><span><?php echo get_post_meta(get_the_ID(), 'bedrooms', true); ?></span>
                            </li>
                            <li class="d-flex justify-content-between border-bottom py-1">
                                <span class="fw-bold text-muted">Bathrooms:</span><span><?php echo get_post_meta(get_the_ID(), 'bathrooms', true); ?></span>
                            </li>
                            <li class="d-flex justify-content-between border-bottom py-1">
                                <span class="fw-bold text-muted">Balconies:</span><span><?php echo get_post_meta(get_the_ID(), 'balconies', true); ?></span>
                            </li>
                            <li class="d-flex justify-content-between border-bottom py-1">
                                <span class="fw-bold text-muted">Area:</span><span><?php echo get_post_meta(get_the_ID(), 'area', true); ?> sq. ft.</span>
                            </li>
                            <li class="d-flex justify-content-between border-bottom py-1">
                                <span class="fw-bold text-muted">Floor:</span><span><?php echo get_post_meta(get_the_ID(), 'floor', true); ?></span>
                            </li>
                            <li class="d-flex justify-content-between border-bottom py-1">
                                <span class="fw-bold text-muted">Furnishing:</span><span><?php echo get_post_meta(get_the_ID(), 'furnishing', true); ?></span>
                            </li>
                            <li class="d-flex justify-content-between border-bottom py-1">
                                <span class="fw-bold text-muted">Facing:</span><span><?php echo get_post_meta(get_the_ID(), 'facing', true); ?></span>
                            </li>
                            <li class="d-flex justify-content-between border-bottom py-1">
                                <span class="fw-bold text-muted">Maintenance:</span><span><?php echo get_post_meta(get_the_ID(), 'maintenance', true); ?></span>
                            </li>
                            <li class="d-flex justify-content-between border-bottom py-1">
                                <span class="fw-bold text-muted">Ownership:</span><span><?php echo get_post_meta(get_the_ID(), 'ownership', true); ?></span>
                            </li>
                            <li class="d-flex justify-content-between border-bottom py-1">
                                <span class="fw-bold text-muted">RERA Registered:</span><span><?php
                                                                                                    $rera_registered = get_post_meta(get_the_ID(), 'rera_registered', true);

                                                                                                    // Case-insensitive check for "Yes" or "No"
                                                                                                    if ($rera_registered) {
                                                                                                        echo "Yes";
                                                                                                    } else {
                                                                                                        echo "No";
                                                                                                    } ?></span>
                            </li>
                            <li class="d-flex justify-content-between py-1">
                                <span class="fw-bold text-muted">Construction Status:</span><span><?php echo get_post_meta(get_the_ID(), 'construction_status', true); ?></span>
                            </li>
                        </ul>
                    </section>
                </div>
            </header>

            <!-- Location Section -->
            <section class="mt-5 bg-white p-4 rounded shadow-sm">
                <h2 class="h5 text-dark border-bottom pb-2 mb-3">Location</h2>
                <p><strong>Neighbourhood:</strong> <?php echo get_post_meta(get_the_ID(), 'neighbourhood', true); ?></p>
                <p><strong>Full Address:</strong> <?php echo get_post_meta(get_the_ID(), 'full_address', true); ?></p>
                <p><strong>Landmark:</strong> <?php echo get_post_meta(get_the_ID(), 'landmark', true); ?></p>
                <p><strong>Pincode:</strong> <?php echo get_post_meta(get_the_ID(), 'pincode', true); ?></p>
            </section>

            <!-- Amenities -->
            <section class="mt-4 bg-white p-4 rounded shadow-sm">
                <h2 class="h5 text-dark border-bottom pb-2 mb-3">Amenities</h2>
                <ul class="list-inline">
                    <?php
                    // Get and display amenities (taxonomy 'property_amenities')
                    $amenities = get_the_terms(get_the_ID(), 'property_amenities');
                    if ($amenities && !is_wp_error($amenities)) {
                        foreach ($amenities as $amenity) {
                            echo '<li class="list-inline-item badge bord bg-light text-prim fw-semibold me-2 mb-2">' . esc_html($amenity->name) . '</li>';
                        }
                    }
                    ?>
                </ul>
            </section>

            <!-- Interior Details -->
            <section class="mt-4 bg-white p-4 rounded shadow-sm">
                <h2 class="h5 text-dark border-bottom pb-2 mb-3">Interior Details</h2>
                <ul class="list-inline">
                    <?php
                    // Get and display interior details (taxonomy 'property_interior_details')
                    $interior_details = get_the_terms(get_the_ID(), 'property_interior_details');
                    if ($interior_details && !is_wp_error($interior_details)) {
                        foreach ($interior_details as $detail) {
                            echo '<li class="list-inline-item badge bord bg-light text-prim fw-semibold me-2 mb-2">' . esc_html($detail->name) . '</li>';
                        }
                    }
                    ?>
                </ul>
            </section>

            <!-- Smart Home Features -->
            <section class="mt-4 bg-white p-4 rounded shadow-sm">
                <h2 class="h5 text-dark border-bottom pb-2 mb-3">Smart Home Features</h2>
                <ul class="list-inline">
                    <?php
                    // Get and display smart home features (taxonomy 'property_smart_home_features')
                    $smart_home_features = get_the_terms(get_the_ID(), 'property_smart_home_features');
                    if ($smart_home_features && !is_wp_error($smart_home_features)) {
                        foreach ($smart_home_features as $feature) {
                            echo '<li class="list-inline-item badge bord bg-light text-prim fw-semibold me-2 mb-2">' . esc_html($feature->name) . '</li>';
                        }
                    }
                    ?>
                </ul>
            </section>

            <!-- Loan Availability -->
            <section class="mt-4 bg-white p-4 rounded shadow-sm">
                <h2 class="h5 text-dark border-bottom pb-2 mb-3">Loan Available From</h2>
                <ul class="list-inline ">
                    <?php
                    // Get and display available loan options (taxonomy 'property_loan_available')
                    $loan_options = get_the_terms(get_the_ID(), 'property_loan_available');
                    if ($loan_options && !is_wp_error($loan_options)) {
                        foreach ($loan_options as $loan) {
                            echo '<li class="list-inline-item badge bord bg-light text-prim fw-semibold me-2 mb-2">' . esc_html($loan->name) . '</li>';
                        }
                    }
                    ?>
                </ul>
            </section>


            <section class="mt-4 bg-white p-4 rounded shadow-sm">
                <h2 class="h5 text-dark border-bottom pb-2 mb-3">Additional Features</h2>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Power Backup:</strong>
                            <?php
                            $backup = get_post_meta(get_the_ID(), 'power_backup', true);
                            if ($backup) {
                                echo "Yes";
                            } else {
                                echo "No";
                            }
                            ?>
                        </p>
                        <p><strong>Water Supply:</strong>
                            <?php
                            $water_supply = get_post_meta(get_the_ID(), 'water_supply', true);
                            if (!empty($water_supply)) {
                                if (is_array($water_supply)) {
                                    // If it's an array, join the values with commas
                                    echo implode(', ', $water_supply);
                                } else {
                                    // If it's a string, display the value directly
                                    echo esc_html($water_supply);
                                }
                            } else {
                                // Display "Not available" if no value is found
                                echo 'Not available';
                            }
                            ?>
                        </p>
                        <p><strong>Security:</strong>
                            <?php
                            $security = get_post_meta(get_the_ID(), 'security', true);

                            if (!empty($security)) {
                                if (is_array($security)) {
                                    // If it's an array, join the values with commas
                                    echo implode(', ', $security);
                                } else {
                                    // If it's a string, display the value directly
                                    echo esc_html($security);
                                }
                            } else {
                                // Display "Not available" if no value is found
                                echo 'Not available';
                            }
                            ?>
                        </p>
                        <p><strong>Pet Friendly:</strong>
                            <?php
                            $pet_friendly = get_post_meta(get_the_ID(), 'pet_friendly', true);

                            // Case-insensitive check for "Yes" or "No"
                            if ($pet_friendly) {
                                echo "Yes";
                            } else {
                                echo "No";
                            }
                            ?>
                        </p>

                    </div>
                    <div class="col-md-6">
                        <p><strong>View:</strong> <?php
                                                    $view = get_post_meta(get_the_ID(), 'view', true);

                                                    if (!empty($view)) {
                                                        if (is_array($view)) {
                                                            // If it's an array, join the values with commas
                                                            echo implode(', ', $view);
                                                        } else {
                                                            // If it's a string, display the value directly
                                                            echo esc_html($view);
                                                        }
                                                    } else {
                                                        // Display "Not available" if no value is found
                                                        echo 'Not available';
                                                    }
                                                    ?></p>
                        <p><strong>Internet:</strong> <?php
                                                        $internet = get_post_meta(get_the_ID(), 'internet', true);

                                                        // Case-insensitive check for "Yes" or "No"
                                                        if ($internet) {
                                                            echo "Yes";
                                                        } else {
                                                            echo "No";
                                                        }
                                                        ?></p>
                        <p><strong>Sewage: </strong><?php $sewage = get_post_meta(get_the_ID(), 'sewage', true);

                                                    if (!empty($sewage)) {
                                                        if (is_array($sewage)) {
                                                            // If it's an array, join the values with commas
                                                            echo implode(', ', $sewage);
                                                        } else {
                                                            // If it's a string, display the value directly
                                                            echo esc_html($sewage);
                                                        }
                                                    } else {
                                                        // Display "Not available" if no value is found
                                                        echo 'Not available';
                                                    }
                                                    ?></p>
                    </div>
                </div>
            </section>



            <!-- Google Map -->
            <section class="mt-4 bg-white p-4 rounded shadow-sm">
                <h2 class="h5 text-dark border-bottom pb-2 mb-3">Location on Map</h2>
                <div class="ratio ratio-21x9 rounded overflow-hidden shadow-sm">
                    <iframe
                        src="https://www.google.com/maps?q=<?php echo esc_attr(get_post_meta(get_the_ID(), 'latitude', true)); ?>,<?php echo esc_attr(get_post_meta(get_the_ID(), 'longitude', true)); ?>&hl=en&z=15&output=embed"
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        aria-label="Google map location"></iframe>
                </div>
            </section>

            <!-- Contact Buttons -->
            <section class="container-fluid text-center sticky-bottom py-3 bg-white border-top shadow-sm mb-5">
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    <a href="tel:<?php echo esc_attr(get_post_meta(get_the_ID(), 'contact_seller', true)); ?>" class="btn btn-prim text-white px-4" style="width:150px;">Contact Seller</a>
                    <a href="https://wa.me/<?php echo esc_attr(get_post_meta(get_the_ID(), 'whatsup_number', true)); ?>" target="_blank" rel="noopener" class="btn btn-success px-4" style="width:150px;">WhatsApp</a>
                </div>
            </section>

        </article>
    </div>

    <!-- JS Logic for Media Gallery -->
    <script>
        const thumbnails = document.querySelectorAll(".thumbnail");
        const mainViewer = document.getElementById("mainViewer");
        let currentIndex = 0;

        const mediaList = Array.from(thumbnails).map((thumb) => ({
            type: thumb.dataset.type,
            src: thumb.dataset.src,
        }));

        function renderMedia(index) {
            const media = mediaList[index];
            mainViewer.innerHTML = '';

            if (media.type === 'video') {
                const video = document.createElement('video');
                video.src = media.src;
                video.controls = true;
                video.autoplay = true;
                video.style.maxHeight = '100%';
                mainViewer.appendChild(video);
            } else {
                const img = document.createElement('img');
                img.src = media.src;
                img.alt = 'Main Media';
                mainViewer.appendChild(img);
            }

            thumbnails.forEach((thumb, i) => {
                thumb.classList.toggle("active", i === index);
            });

            currentIndex = index;
        }

        thumbnails.forEach((thumb, index) => {
            thumb.addEventListener("click", () => renderMedia(index));
        });

        function changeMedia(direction) {
            let newIndex = currentIndex + direction;
            if (newIndex < 0) newIndex = mediaList.length - 1;
            if (newIndex >= mediaList.length) newIndex = 0;
            renderMedia(newIndex);
        }

        renderMedia(0);
    </script>

</body>

</html>

<?php get_footer(); ?>
