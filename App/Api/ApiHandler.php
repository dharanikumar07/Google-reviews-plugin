<?php
namespace GPRC\App\Api;

defined('ABSPATH') || exit;

class ApiHandler
{
    /**
     * Fetch Google Place Reviews for a given place ID.
     *
     * @param string $place_id The Google Place ID to fetch reviews for.
     *
     * @return void
     */
    public static function gprFetchReviews($place_id)
    {
        $api_url = "https://maps.googleapis.com/maps/api/place/details/json";
        $api_key = get_option('gpr_api_key', true);
        $response = wp_remote_get(
            add_query_arg(
                [
                    'key' => $api_key,
                    'placeid' => $place_id
                ],
                $api_url
            )
        );

        if (is_wp_error($response)) {
            return wp_send_json_error(['message' => __('Failed to fetch reviews.', 'yuko')]);
        }

        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);

        if (isset($data['result'])) {
            $reviews = [
                'place_id' => $data['result']['place_id'] ?? $place_id,
                'rating' => $data['result']['rating'] ?? 0,
                'user_ratings_total' => $data['result']['user_ratings_total'] ?? 0,
                'reviews' => $data['result']['reviews'] ?? []
            ];
            self::saveReviewsToDb($reviews);
        } else {
            return wp_send_json_error(['message' => __('Reviews not found.', 'yuko')]);
        }
    }

    /**
     * Fetch the Place ID based on the search query.
     *
     * @return void
     */
    public static function gprFetchPlaceId()
    {
        check_ajax_referer('gpr_nonce', 'security');

        if (isset($_POST['query'])) {
            $query = sanitize_text_field(wp_unslash($_POST['query']));
        }

        if (empty($query)) {
            wp_send_json_error(['message' => __('Search query cannot be empty.', 'yuko')]);
            return;
        }

        $api_url = "https://places.googleapis.com/v1/places:searchText";

        // API Request to fetch Place ID
        $response = wp_remote_post($api_url, [
            'body' => wp_json_encode(['textQuery' => $query]),
            'headers' => [
                'Content-Type' => 'application/json',
                'X-Goog-Api-Key' => 'AIzaSyC0TrePd3JavfAT_vKC8oJleFwITlT6eAw', // Replace with your Google API Key
                'X-Goog-FieldMask' => 'places.id,places.displayName,places.formattedAddress',
            ],
        ]);

        if (is_wp_error($response)) {
            wp_send_json_error(['message' => __('API request failed.', 'yuko')]);
            return;
        }

        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);
        $place_id = $data['places'][0]['id'] ?? null;

        if ($place_id) {
            return self::gprFetchReviews($place_id);
        } else {
            wp_send_json_error(['message' => __('Place not found.', 'yuko')]);
        }
    }

    /**
     * Save the fetched reviews to the WordPress database.
     *
     * @param array $reviews The reviews data to be saved.
     *
     * @return void
     */
    public static function saveReviewsToDb($reviews)
    {
        $serialized_reviews = maybe_serialize([
            'place_id' => $reviews['place_id'],
            'reviews' => $reviews['reviews'],
            'rating' => $reviews['rating'],
            'user_ratings_total' => $reviews['user_ratings_total'],
            'updated_at' => current_time('mysql'),
        ]);

        update_option('latest_gpr_search', $serialized_reviews);

        self::fetchViews($reviews);
    }

    /**
     * Retrieve the reviews data stored in the database.
     *
     * @return array The list of reviews or an empty array if no reviews are found.
     */
    public static function getReviewsData()
    {
        $serialized_reviews = get_option('latest_gpr_search');

        if ($serialized_reviews) {
            $reviews_data = maybe_unserialize($serialized_reviews);

            if (!empty($reviews_data['reviews'])) {
                return $reviews_data['reviews'];
            }
        }

        return [];
    }

    /**
     * Fetch and render the reviews into HTML.
     *
     * @param array $reviews The reviews data to be rendered.
     *
     * @return void
     */
    public static function fetchViews($reviews)
    {
        if (!empty($reviews)) {
            ob_start();
            include GPRC_PLUGIN_PATH . 'App/Views/reviews.php';
            $content = ob_get_clean();

            if (empty($content)) {
                echo esc_html__('No content captured', 'yuko');
            }

            return wp_send_json_success(['content' => $content]);
        } else {
            echo '<p>' . esc_html__('No reviews available.', 'yuko') . '</p>';
        }
    }
}

