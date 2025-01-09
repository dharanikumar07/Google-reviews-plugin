<?php
/**
 * Plugin Name:          Google Place Reviews
 * Description:          Fetch Google Place reviews by searching for a place.
 * Version:              1.0.0
 * Requires PHP:         7.4
 * Author:               Dharanikumar
 * Text Domain:          cr-google-place-reviews
 * Domain Path:          /i18n/languages
 * License:              GPL v3 or later
 * License URI:          https://www.gnu.org/licenses/gpl-3.0.html
 */
use GPRC\App\Router;

defined('ABSPATH') || exit;


// Define constants
defined( 'GPRC_PLUGIN_PATH' ) or define( 'GPRC_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
defined( 'GPRC_PLUGIN_URL' ) or define( 'GPRC_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
defined( 'GPRC_PLUGIN_VERSION' ) || define( 'GPRC_PLUGIN_VERSION', '1.0.0' );

if ( ! class_exists( 'GPRC\App\Router' ) ) {
    require GPRC_PLUGIN_PATH . '/vendor/autoload.php';
}

if(file_exists(GPRC_PLUGIN_PATH . 'includes/api-handler.php')) {
    require_once GPRC_PLUGIN_PATH . 'includes/api-handler.php';
}

add_action( 'plugins_loaded', function () {
    if ( class_exists( Router::class )) {
            Router::init();
    }
} );