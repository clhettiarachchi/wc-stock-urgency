<?php
defined('ABSPATH') || exit;

class WC_Urgency_Admin
{

    public function __construct()
    {
        add_action('admin_menu', array($this, 'add_settings_page'));
        add_action('admin_init', array($this, 'register_settings'));
    }

    // Add settings page under the WooCommerce menu.
    public function add_settings_page()
    {
        add_submenu_page(
            'woocommerce',
            __('Stock Urgency Settings', 'wc-stock-urgency'),
            __('Stock Urgency', 'wc-stock-urgency'),
            'manage_options',
            'wc-stock-urgency',
            array($this, 'render_settings_page')
        );
    }

    // Register settings, sections, and fields.
    public function register_settings()
    {
        register_setting(
            'wc_urgency_settings_group',
            'wc_urgency_low_threshold',
            array(
                'sanitize_callback' => 'absint',
                'default'           => 10,
            )
        );

        register_setting(
            'wc_urgency_settings_group',
            'wc_urgency_critical_threshold',
            array(
                'sanitize_callback' => 'absint',
                'default'           => 3,
            )
        );

        add_settings_section(
            'wc_urgency_main_section',
            __('Threshold Settings', 'wc-stock-urgency'),
            null,
            'wc-stock-urgency'
        );

        add_settings_field(
            'wc_urgency_low_threshold',
            __('Low Stock Threshold', 'wc-stock-urgency'),
            array($this, 'render_low_threshold_field'),
            'wc-stock-urgency',
            'wc_urgency_main_section'
        );

        add_settings_field(
            'wc_urgency_critical_threshold',
            __('Critical Stock Threshold', 'wc-stock-urgency'),
            array($this, 'render_critical_threshold_field'),
            'wc-stock-urgency',
            'wc_urgency_main_section'
        );
    }

    public function render_low_threshold_field()
    {
        $value = get_option('wc_urgency_low_threshold', 10);
        echo '<input type="number" min="1" name="wc_urgency_low_threshold" value="' . esc_attr($value) . '">';
        echo '<p class="description">' . esc_html__('Stock at or below this level shows the amber notice.', 'wc-stock-urgency') . '</p>';
    }

    public function render_critical_threshold_field()
    {
        $value = get_option('wc_urgency_critical_threshold', 3);
        echo '<input type="number" min="1" name="wc_urgency_critical_threshold" value="' . esc_attr($value) . '">';
        echo '<p class="description">' . esc_html__('Stock at or below this level shows the red notice.', 'wc-stock-urgency') . '</p>';
    }

    public function render_settings_page()
    {
?>
        <div class="wrap">
            <h1><?php esc_html_e('Stock Urgency Settings', 'wc-stock-urgency'); ?></h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('wc_urgency_settings_group');
                do_settings_sections('wc-stock-urgency');
                submit_button();
                ?>
            </form>
        </div>
<?php
    }
}
