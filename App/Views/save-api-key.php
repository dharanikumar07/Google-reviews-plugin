<?php
$update = get_option('gpr_update_api_key');
?>
<div class="yuko-notification"></div>
<div class="wrap">
    <h1 class="gpr-heading"><?php echo esc_html__('Google Place Reviews', 'yuko'); ?></h1>
    <p class="gpr-subheading"><?php echo esc_html__('Please follow these steps to set up your Google Places API key:', 'yuko'); ?></p>

    <form id="gpr-api-key-form" method="POST" class="gpr-form">
        <input
                type="text"
                id="gpr-api-key"
                class="gpr-input-field"
                placeholder="<?php echo esc_attr__('Enter your API key...', 'yuko'); ?>"
        />
        <?php if ($update === 'update') { ?>
            <button
                    id="gpr-api-key-submit"
                    class="gpr-submit-btn"
            >
                <?php echo esc_html__('Update API Key', 'yuko'); ?>
            </button>
        <?php } else { ?>
            <button
                    id="gpr-api-key-submit"
                    class="gpr-submit-btn"
            >
                <?php echo esc_html__('Save API Key', 'yuko'); ?>
            </button>
        <?php } ?>
    </form>

    <ol class="gpr-steps">
        <li><?php echo esc_html__('Visit', 'yuko'); ?> <a href="https://console.cloud.google.com/" target="_blank" class="gpr-link"><?php echo esc_html__('Google Cloud Console', 'yuko'); ?></a> <?php echo esc_html__('and sign in.', 'yuko'); ?></li>
        <li><?php echo esc_html__('Click the', 'yuko'); ?> <b><?php echo esc_html__('Project dropdown', 'yuko'); ?></b> <?php echo esc_html__('in the top-left corner and select', 'yuko'); ?> <b><?php echo esc_html__('New Project', 'yuko'); ?></b>. <?php echo esc_html__('Enter a name for your project and click', 'yuko'); ?> <b><?php echo esc_html__('Create', 'yuko'); ?></b>.</li>
        <li><?php echo esc_html__('Search for', 'yuko'); ?> <b><?php echo esc_html__('Places API', 'yuko'); ?></b> <?php echo esc_html__('in the search bar, click on it, and then click', 'yuko'); ?> <b><?php echo esc_html__('Enable', 'yuko'); ?></b> <?php echo esc_html__('to activate the API for your project.', 'yuko'); ?></li>
        <li><?php echo esc_html__('Go to', 'yuko'); ?> <b><?php echo esc_html__('APIs & Services > Credentials', 'yuko'); ?></b>, <?php echo esc_html__('click', 'yuko'); ?> <b><?php echo esc_html__('Create Credentials', 'yuko'); ?></b>, <?php echo esc_html__('and select', 'yuko'); ?> <b><?php echo esc_html__('API Key', 'yuko'); ?></b>. <?php echo esc_html__('Your API Key will be generated.', 'yuko'); ?></li>
        <li><?php echo esc_html__('Click', 'yuko'); ?> <b><?php echo esc_html__('Restrict Key', 'yuko'); ?></b>, <?php echo esc_html__('set', 'yuko'); ?> <b><?php echo esc_html__('HTTP Referrers', 'yuko'); ?></b> <?php echo esc_html__('for your domain, select', 'yuko'); ?> <b><?php echo esc_html__('Places API', 'yuko'); ?></b> <?php echo esc_html__('under', 'yuko'); ?> <b><?php echo esc_html__('API Restrictions', 'yuko'); ?></b>, <?php echo esc_html__('and click', 'yuko'); ?> <b><?php echo esc_html__('Save', 'yuko'); ?></b>.</li>
    </ol>

    <p class="gpr-subheading"><?php echo esc_html__('After completing the steps, enter your API key above:', 'yuko'); ?></p>

    <div id="gpr-api-status" class="gpr-status"></div>
</div>
