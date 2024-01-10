<?php
$loader      = get_field('loader', 'option');
$video_files = $loader['video_files'];
$show_loader = $loader['show_loader'];

if (!empty($video_files)) : ?>
    <div class="loader" data-show="<?php echo $show_loader ? 'true' : 'false'; ?>" <?php echo $loader['show_loader'] === false ? 'style="display: none;"' : ''; ?>>
        <div class="loader-in" data-type="video-player">
            <img src="<?php echo get_template_directory_uri() ?>/images/62bc3fe7d9cc61c15b2615e4_load-logo.svg" loading="lazy" alt class="image-3">
            <div class="html-embed w-embed">
                <div class="video_player_box" style="width:100%; height:100%">
                    <video class="my_video" autoplay loop muted playsinline style="width:100%; height:100%; object-fit: cover" data-type="video">
                        <?php foreach ($video_files as $video_file) : ?>
                            <source src="<?php echo $video_file['video_file']['url']; ?>" type="<?php echo $video_file['video_file']['mime_type']; ?>">
                        <?php endforeach; ?>
                    </video>
                </div>
            </div>
            <div class="player-bottom">
                <a href="#" data-type="sound" class="mute-btn w-button">unmute</a>
                <div class="div-block-18">
                    <div class="div-block-14">
                        <div class="progress" data-type="progress-bar">
                            <div class="progress__filled" data-type="progress-line"></div>
                        </div>
                    </div>
                    <div class="progress-counter">−<span id="video-counter" data-type="time-counter">00:00</span></div>
                </div>
                <a data-type="skip-button" data-w-id="b8770955-afd1-2b36-cac0-224d794ab4fd" href="#" class="skip-btn w-inline-block">
                    <div>skip →</div>
                </a>
            </div>
        </div>
    </div>
<?php endif; ?>