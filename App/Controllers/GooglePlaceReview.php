<?php

namespace GPRC\App\Controllers;

class GooglePlaceReview
{
    public static function gprAddAdminMenu() {
        add_menu_page(
            'Google Place Reviews',
            'Place Reviews',
            'manage_options',
            'google-place-reviews',
            [ self::class, 'gprRenderAdminPage' ],
            'dashicons-location-alt',
            25
        );
    }
    public static function gprEnqueueFrontPageCss(){
        wp_enqueue_style('gpr-style', GPRC_PLUGIN_URL . 'assets/css/style.css');
    }
    public static function gprEnqueueScript($hook) {
        if ($hook == 'toplevel_page_google-place-reviews') {
            wp_enqueue_style('gpr-style', GPRC_PLUGIN_URL . 'assets/css/style.css');
            wp_enqueue_script('gpr-frontend', GPRC_PLUGIN_URL . 'assets/js/script.js', ['jquery'], false, true);

            wp_enqueue_style('gprc-toastr-css', 'https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css');
            wp_enqueue_script('gprc-toastr-js', 'https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js', [], false, true);

            wp_localize_script('gpr-frontend', 'gprData', [
                'ajax_url' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('gpr_nonce'),
            ]);
        }
    }

    public static function gprRenderAdminPage() {

        $api_key = get_option('gpr_api_key');

        $update_key = get_option('gpr_update_api_key');

        if (empty($api_key) || $update_key==='update') {
            include GPRC_PLUGIN_PATH . 'App/Views/save-api-key.php';
        } else {
            include GPRC_PLUGIN_PATH . 'App/Views/search.php';
        }
    }

    public static function gprSaveApiKey() {
        if (isset($_POST['nonce']) && wp_verify_nonce($_POST['nonce'], 'gpr_nonce')) {

            $api_key = sanitize_text_field($_POST['api_key']);

            update_option('gpr_api_key', $api_key);

            $update=get_option('gpr_update_api_key');

            if($update=='update'){

                update_option('gpr_update_api_key','no_update');

                wp_send_json_success(['message' => 'API key Updated successfully.']);
            }
            wp_send_json_success(['message' => 'API key saved successfully.']);
        } else {
            wp_send_json_error(['message' => 'Invalid nonce.']);
        }
    }
    public static function gprUpdateApiKey() {
        if (isset($_POST['nonce']) && wp_verify_nonce($_POST['nonce'], 'gpr_nonce')) {

            update_option('gpr_update_api_key', $_POST['update']);

            self::gprRenderAdminPage();

            $html_content = ob_get_clean();

            wp_send_json_success(array('html' => $html_content));
        }else{
            wp_send_json_error(array('message' => 'Failed to update the API Key.'));
        }
    }
    public static function addShortCodes(){
        ob_start();
        include GPRC_PLUGIN_PATH . 'App/Views/reviews.php';
        $content = ob_get_clean();
        return $content;
    }
}