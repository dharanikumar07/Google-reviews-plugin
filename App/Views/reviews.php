<?php
// Include the necessary function to fetch the reviews
use GPRC\App\Api\ApiHandler;

// Fetch the reviews
$reviews = ApiHandler::getReviewsData();
if (!is_admin()) {
    ?>
    <style>
        .gprc-author-photo {
            width: 50px;
            height: 50px;
            border-radius: 50%;  /* Circular photo */
            margin-right: 15px;
            transform: translateY(-24px);  /* Move the photo upwards */
        }
    </style>
    <?php
}
// Check if reviews are available
if (empty($reviews)) {
    ?>
    <div class="yuko-notification"></div>
    <div class="gprc-no-reviews">
        <h5><?php echo esc_html__('No Reviews Yet', 'yuko'); ?></h5>
        <p><?php echo esc_html__('At this time, there are no reviews available. We appreciate your continued partnership and encourage you to reach out if you have any questions or require further assistance.', 'yuko'); ?></p>
    </div>
    <?php
} else {
    // Render the reviews
    ?>
    <div class="gprc-reviews-container">
        <?php foreach ($reviews as $review) { ?>
            <div class="gprc-review-card">
                <div class="gprc-review-header">
                    <img src="<?php echo esc_url($review['profile_photo_url']); ?>" alt="<?php echo esc_attr($review['author_name']); ?>" class="gprc-author-photo">
                    <div class="gprc-author-info">
                        <h3><?php echo esc_html($review['author_name']); ?></h3>
                        <p><a href="<?php echo esc_url($review['author_url']); ?>" target="_blank"><?php echo esc_html__('Visit Profile', 'yuko'); ?></a></p>
                    </div>
                </div>
                <div class="gprc-review-body">
                    <p><strong><?php echo esc_html__('Rating:', 'yuko'); ?></strong> <?php echo esc_html($review['rating']); ?>/5</p>
                    <p><strong><?php echo esc_html__('Review:', 'yuko'); ?></strong> <?php echo esc_html($review['text']); ?></p>
                    <p><strong><?php echo esc_html__('Date:', 'yuko'); ?></strong> <?php echo esc_html($review['relative_time_description']); ?></p>
                </div>
            </div>
        <?php } ?>
    </div>
    <?php
}
?>
