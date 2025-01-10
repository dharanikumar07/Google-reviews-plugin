<div class="yuko-notification"></div>
<div class="gpr-integration">
    <div class="gpr-notification"></div>
    <div class="gpr-wrap">
        <div class="gpr-header">
            <h1 class="gpr-heading"><?php echo esc_html__('Google Place Reviews', 'yuko'); ?></h1>
            <button id="gpr-update-api-btn" class="gpr-button gpr-button-secondary">
                <?php echo esc_html__('Update API Key', 'yuko'); ?>
            </button>
        </div>
        <p class="gpr-description"><?php echo esc_html__('Search a place to get its reviews', 'yuko'); ?></p>

        <div id="gpr-search-wrap" class="gpr-search-wrap">
            <input type="text" id="gpr-place-search" class="gpr-input-field" placeholder="<?php echo esc_attr__('Enter a place name...', 'yuko'); ?>" />
            <button id="gpr-search-btn" class="gpr-button gpr-button-primary" disabled>
                <?php echo esc_html__('Search', 'yuko'); ?>
            </button>
        </div>
        <br>
        <div id="gpr-result" class="gpr-result"><?php echo esc_html__('No reviews....', 'yuko'); ?></div>
    </div>
</div>
