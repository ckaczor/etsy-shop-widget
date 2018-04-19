<?php
/**
 * PHP version 5
 *
 * @category Category
 * @package  Etsy_Shop_Widget
 * @author   Chris Kaczor <chris@kaczor.us>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://kaczor.us
 */

/**
 * Handles requests for listings
 *
 * @return null
 */
function ESW_Listings_request()
{
    $listings = get_transient('etsy_shop_widget_listings');

    if ($listings === false) {
        $options = get_option('ESW_settings');

        $response = wp_remote_request('https://openapi.etsy.com/v2/shops/' . $options['ESW_Etsy_Shop_Name'] . '/listings/active?includes=MainImage&api_key=' . $options['ESW_Etsy_API_Key'] . '');

        $listings = $response['body'];

        set_transient('etsy_shop_widget_listings', $listings, $options['ESW_Cache_Time'] * 60);
    }

    echo $listings;

    die();
}

add_action('admin_post_esw_listings', 'ESW_Listings_request');
add_action('admin_post_nopriv_esw_listings', 'ESW_Listings_request');

/**
 * Handles requests for to clear cache
 *
 * @return null
 */
function ESW_Clear_Cache_request()
{
    delete_transient('etsy_shop_widget_listings');

    die();
}

add_action('admin_post_esw_clearcache', 'ESW_Clear_Cache_request');

/**
 * Handles shortcode
 *
 * @return null
 */
function ESW_shortcode()
{
    return '<div id="etsy-shop-widget"></div>';
}

add_shortcode('etsy-shop-widget', 'ESW_shortcode');
