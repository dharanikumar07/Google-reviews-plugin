<?php

namespace GPRC\App;

use GPRC\App\Controllers\GooglePlaceReview;
use GPRC\App\Api\ApiHandler;

class Router
{
    public static function init()
    {
        if (!is_admin()) {
            add_action( 'wp_enqueue_scripts', [GooglePlaceReview::class, 'gprEnqueueFrontPageCss' ], 100 );
        }else{
            add_action( 'admin_menu', [ GooglePlaceReview::class, 'gprAddAdminMenu' ], 100 );
            add_action( 'admin_enqueue_scripts', [GooglePlaceReview::class, 'gprEnqueueScript' ], 100 );
        }
        if(wp_doing_ajax()){
            add_action( 'wp_ajax_gpr_fetch_place_id', [ ApiHandler::class, 'gprFetchPlaceId' ], 100 );
            add_action( 'wp_ajax_nopriv_gpr_fetch_place_id', [ ApiHandler::class, 'gprFetchPlaceId' ], 100 );
            add_action( 'wp_ajax_gpr_save_api_key', [ GooglePlaceReview::class, 'gprSaveApiKey' ], 100 );
            add_action( 'wp_ajax_nopriv_gpr_save_api_key', [ GooglePlaceReview::class, 'gprSaveApiKey' ], 100 );
            add_action( 'wp_ajax_gpr_update_api_key', [ GooglePlaceReview::class, 'gprUpdateApiKey' ], 100 );
            add_action( 'wp_ajax_nopriv_gpr_update_api_key', [ GooglePlaceReview::class, 'gprUpdateApiKey' ], 100 );
        }
        add_shortcode('google_reviews_data', [GooglePlaceReview::class, 'addShortCodes']);
    }
}