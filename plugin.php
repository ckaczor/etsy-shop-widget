<?php
/**
 * Plugin Name:   Etsy Shop Widget
 * Plugin URI:    https://kaczor.us
 * Description:   Adds a widget to display the contents of an Etsy shop.
 * Version:       1.0
 * Author:        Chris Kaczor
 * Author URI:    https://kaczor.us
 *
 * PHP version 5
 *
 * @category Category
 * @package  Etsy_Shop_Widget
 * @author   Chris Kaczor <chris@kaczor.us>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://kaczor.us
 */

if (defined('ESW_PLUGIN_VER')) {
    return;
}

define('ESW_PLUGIN_VER', '0.0.1');
define('ESW_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('ESW_PLUGIN_URL', plugin_dir_url(__FILE__));
define('ESW_PLUGIN_BASENAME', plugin_basename(__FILE__));

require_once __DIR__ . '/php/webpack_enqueue.php';

require_once __DIR__ . '/php/options.php';

require_once __DIR__ . '/php/actions.php';