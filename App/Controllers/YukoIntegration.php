<?php
namespace GPRC\App\Controllers;

class YukoIntegration
{
    public static function gprAddAdminMenu() {
        add_menu_page(
            __('Yuko', 'yuko'),
            __('Reviews', 'yuko'),
            'manage_options',
            'yuko',
            [ self::class, 'gprRenderAdminPage' ],
            'dashicons-location-alt',
            25
        );
    }

    public static function gprEnqueueFrontPageCss(){
        wp_enqueue_style('gpr-style', GPRC_PLUGIN_URL . 'assets/css/style.css', [], filemtime(GPRC_PLUGIN_PATH . 'assets/css/style.css'));
    }

    public static function gprEnqueueScript($hook) {
        if ($hook == 'toplevel_page_yuko') {
            wp_enqueue_style('gpr-style', GPRC_PLUGIN_URL . 'assets/css/style.css', [], filemtime(GPRC_PLUGIN_PATH . 'assets/css/style.css'));
            wp_enqueue_script('gpr-frontend', GPRC_PLUGIN_URL . 'assets/js/script.js', ['jquery'], filemtime(GPRC_PLUGIN_PATH . 'assets/js/script.js'), true);

            wp_localize_script('gpr-frontend', 'gprData', [
                'ajax_url' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('gpr_nonce'),
            ]);
        }
    }

    public static function gprRenderAdminPage() {
        $api_key = get_option('gpr_api_key');
        $update_key = get_option('gpr_update_api_key');

        if (empty($api_key) || $update_key === 'update') {
            include GPRC_PLUGIN_PATH . 'App/Views/save-api-key.php';
        } else {
            include GPRC_PLUGIN_PATH . 'App/Views/search.php';
        }
    }

    public static function gprSaveApiKey() {
        if (isset($_POST['nonce']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'gpr_nonce')) {

            $api_key = isset($_POST['api_key']) ? sanitize_text_field(wp_unslash($_POST['api_key'])) : '';
            update_option('gpr_api_key', $api_key);

            $update = get_option('gpr_update_api_key');

            if ($update == 'update') {
                update_option('gpr_update_api_key', 'no_update');
                wp_send_json_success(['message' => __('API key Updated successfully.', 'yuko')]);
            }
            wp_send_json_success(['message' => __('API key saved successfully.', 'yuko')]);
        } else {
            wp_send_json_error(['message' => __('Invalid nonce.', 'yuko')]);
        }
    }

    public static function gprUpdateApiKey() {
        if (isset($_POST['nonce']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'gpr_nonce')) {

            if (isset($_POST['update'])) {
                update_option('gpr_update_api_key', sanitize_text_field(wp_unslash($_POST['update'])));
            }

            self::gprRenderAdminPage();

            $html_content = ob_get_clean();
            wp_send_json_success(array('html' => $html_content));
        } else {
            wp_send_json_error(array('message' => __('Failed to update the API Key.', 'yuko')));
        }
    }

    public static function addShortCodes(){
        ob_start();
        include GPRC_PLUGIN_PATH . 'App/Views/reviews.php';
        $content = ob_get_clean();
        return $content;
    }
}
