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
 * Loads scripts
 *
 * @return null
 */
function ESW_Load_scripts()
{
    wp_enqueue_style('main', ESW_PLUGIN_URL . '/assets/style.css', null, ESW_PLUGIN_VER, 'all');

    wp_enqueue_script('vendor', ESW_PLUGIN_URL . '/assets/vendor.js', null, ESW_PLUGIN_VER, true);
    wp_enqueue_script('main', ESW_PLUGIN_URL . '/assets/main.js', array('vendor'), ESW_PLUGIN_VER, true);

    wp_localize_script('main', 'esw_wp', array( 'siteurl' => get_option('siteurl') ));
}

add_action('wp_enqueue_scripts', 'ESW_Load_scripts');
