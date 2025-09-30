

                        <!-- 🔽 Video Gallery Content Starts Here -->
                        <h2 class="text-center mb-5">🎬 Featured Video Gallery</h2>

                        <?php
                        $youtube_videos = [
                            'https://www.youtube.com/shorts/a1-T2Pj_CDg',
                            'https://www.youtube.com/shorts/E1FUGWVInuM',
                            'https://www.youtube.com/shorts/wrIgzJTT8I0'
                        ];

                        $instagram_videos = [
                            'https://www.instagram.com/p/DOmzWzsgtBY/',
                            'https://www.instagram.com/p/DOYVKpLDKOa/',
                            'https://www.instagram.com/p/DN-rMi7jGuF/'
                        ];

                        $all_videos = array_merge($youtube_videos, $instagram_videos);
                        ?>

                        <div class="video-grid">
                            <?php foreach ($all_videos as $video_url): ?>
                                <div class="video-card">
                                    <?php if (strpos($video_url, 'youtube.com/shorts/') !== false): ?>
                                        <iframe
                                            src="<?php echo str_replace('/shorts/', '/embed/', $video_url); ?>"
                                            frameborder="0"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                            allowfullscreen>
                                        </iframe>
                                    <?php elseif (strpos($video_url, 'instagram.com') !== false): ?>
                                        <iframe
                                            src="<?php echo esc_url($video_url); ?>embed"
                                            frameborder="0"
                                            allowtransparency="true"
                                            allowfullscreen
                                            scrolling="no">
                                        </iframe>
                                    <?php endif; ?>

                                    <div class="custom-button-group"> 
                   <a href="https://upgrade.urbanfeatconstruction.com/contact-2/" class="custom-btn red-btn">Enquiry</a> 
                   <a href="https://wa.me/917239001002" target="_blank" class="custom-btn green-btn">WhatsApp</a> 
                   </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <!-- 🔼 Video Gallery Content Ends Here -->

                        <style>
                            .video-grid {
                                display: grid;
                                grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                                gap: 30px;
                                margin-top: 40px;
                            }

                            .video-card iframe {
    width: 100%;
    height: 400px;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

/* Buttons */
.custom-button-group {
    margin-top: 15px;
    display: flex;
    justify-content: space-between;
    gap: 15px;
}

.custom-btn {
    text-decoration: none;
    padding: 10px 50px;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 800;
    color: white;
    transition: background-color 0.3s ease;
    display: inline-block;
}

.red-btn {
    background-color: #b30000;
}

.red-btn:hover {
    background-color: #800000;
}

.green-btn {
    background-color: #006400;
}

.green-btn:hover {
    background-color: #004d00;
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


