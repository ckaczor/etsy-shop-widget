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

add_action('admin_menu', 'ESW_Add_Admin_menu');
add_action('admin_init', 'ESW_Settings_init');

/**
 * Adds admin menu
 *
 * @return null
 */
function ESW_Add_Admin_menu()
{
    add_options_page('Etsy Shop Widget', 'Etsy Shop Widget', 'manage_options', 'etsy_shop_widget', 'ESW_Options_page');
}

/**
 * Initializes settings
 *
 * @return null
 */
function ESW_Settings_init()
{
    wp_enqueue_style('settings', ESW_PLUGIN_URL . '/php/settings.css', null, ESW_PLUGIN_VER, 'all');

    register_setting('pluginPage', 'ESW_settings');

    add_settings_section(
        'ESW_pluginPage_section',
        '',
        '',
        'pluginPage'
    );

    add_settings_field(
        'ESW_Etsy_API_Key',
        __('Etsy API key', 'wordpress'),
        'ESW_API_Key_render',
        'pluginPage',
        'ESW_pluginPage_section'
    );

    add_settings_field(
        'ESW_Etsy_Shop_Name',
        __('Etsy shop name', 'wordpress'),
        'ESW_Shop_Name_render',
        'pluginPage',
        'ESW_pluginPage_section'
    );

    add_settings_field(
        'ESW_Cache_Time',
        __('Cache duration', 'wordpress'),
        'ESW_Cache_Time_render',
        'pluginPage',
        'ESW_pluginPage_section'
    );

    $options = get_option('ESW_settings');

    if ($options['ESW_Cache_Time'] === '') {
        $options['ESW_Cache_Time'] = 1;

        update_option('ESW_settings', $options);
    }
}

/**
 * Render API key
 *
 * @return null
 */
function ESW_API_Key_render()
{
    $options = get_option('ESW_settings');

    ?>

    <input type='text' id='esw-etsy-api-key' name='ESW_settings[ESW_Etsy_API_Key]' value='<?php echo $options['ESW_Etsy_API_Key']; ?>'>

    <?php
}

/**
 * Render shop name
 *
 * @return null
 */
function ESW_Shop_Name_render()
{
    $options = get_option('ESW_settings');

    ?>

    <input type='text' id='esw-etsy-shop-name' name='ESW_settings[ESW_Etsy_Shop_Name]' value='<?php echo $options['ESW_Etsy_Shop_Name']; ?>'>

    <?php
}

/**
 * Render cache time
 *
 * @return null
 */
function ESW_Cache_Time_render()
{
    $options = get_option('ESW_settings');

    ?>

    <input id='esw-cache-time' type='number' min='1' max='24' name='ESW_settings[ESW_Cache_Time]' value='<?php echo $options['ESW_Cache_Time']; ?>'>
    hours

    <btn id='esw-cache-clear-now' class="button button-primary" onclick="clearCache()">Clear Now</btn>
    <span id='esw-cache-clear-now-done' class="dashicons dashicons-yes"></span>

    <?php
}

/**
 * Render options page
 *
 * @return null
 */
function ESW_Options_page()
{
    $site_url = get_site_url();

    ?>

    <script>
        function clearCache() {
            jQuery('#esw-cache-clear-now').attr('disabled', true);
            jQuery('#esw-cache-clear-now-done').css('visibility', 'hidden');

            jQuery.post('<?php echo $site_url ?>/wp-admin/admin-post.php?action=esw_clearcache', undefined, (response) => {
                jQuery('#esw-cache-clear-now').attr('disabled', false);
                jQuery('#esw-cache-clear-now-done').css('visibility', 'visible');

                setTimeout(() => {
                    jQuery('#esw-cache-clear-now-done').css('visibility', 'hidden');
                }, 2000);
            });
        }
    </script>

    <form action='options.php' method='post'>
        <h2>Etsy Shop Widget</h2>

        <?php

        settings_fields('pluginPage');
        do_settings_sections('pluginPage');
        submit_button();

        ?>
    </form>

    <?php
}

?>