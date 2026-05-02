<?php

/**
 * Plugin Name:       WC Stock Urgency Notifier
 * Description:       Displays a dynamic, colour-coded stock urgency message on WooCommerce single product pages.
 * Version:           1.0.0
 * Author:            Chandika Hettiarachchi
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       wc-stock-urgency
 * Requires Plugins:  woocommerce
 */

defined('ABSPATH') || exit;

// ---------------------------------------------------------------------------
// Constants
// ---------------------------------------------------------------------------

define('WC_URGENCY_VERSION', '1.0.0');
define('WC_URGENCY_PATH',    plugin_dir_path(__FILE__));
define('WC_URGENCY_URL',     plugin_dir_url(__FILE__));

// ---------------------------------------------------------------------------
// WooCommerce dependency check
// ---------------------------------------------------------------------------

add_action('plugins_loaded', 'wc_urgency_init', 10);

function wc_urgency_init()
{
    if (! class_exists('WooCommerce')) {
        add_action('admin_notices', 'wc_urgency_missing_wc_notice');
        return;
    }

    require_once WC_URGENCY_PATH . 'includes/class-frontend.php';
    require_once WC_URGENCY_PATH . 'includes/class-admin.php';

    new WC_Urgency_Frontend();
    new WC_Urgency_Admin();
}

function wc_urgency_missing_wc_notice()
{
?>
    <div class="notice notice-error">
        <p>
            <?php
            echo wp_kses_post(
                sprintf(
                    /* translators: %s: WooCommerce plugin link */
                    __('<strong>WC Stock Urgency Notifier</strong> requires %s to be installed and active.', 'wc-stock-urgency'),
                    '<a href="https://woocommerce.com" target="_blank" rel="noopener noreferrer">WooCommerce</a>'
                )
            );
            ?>
        </p>
    </div>
<?php
}
