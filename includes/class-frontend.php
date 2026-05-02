<?php
defined('ABSPATH') || exit;

class WC_Urgency_Frontend
{

    public function __construct()
    {
        add_action('woocommerce_single_product_summary', array($this, 'render_notice'), 25);
        add_action('wp_enqueue_scripts', array($this, 'enqueue_styles'));
    }

    public function render_notice()
    {
        global $product;

        $stock_qty = $product->get_stock_quantity();
        $status = $this->get_urgency_status($stock_qty);

        // Map each status to its display message.
        $messages = array(
            'high'     => 'In stock and ready to ship',
            'low'      => 'Only ' . $stock_qty . ' left in stock',
            'critical' => 'Last ' . $stock_qty . ' remaining — order soon!',
        );

        echo '<div class="wc-urgency-notice wc-urgency-notice--' . esc_attr($status) . '">';
        echo '<span class="wc-urgency-notice__icon"></span>';
        echo '<p class="wc-urgency-notice__text">' . esc_html($messages[$status]) . '</p>';
        echo '</div>';
    }

    /**
     * Returns urgency status based on stock quantity.
     *
     * @param int $qty Current stock quantity.
     * @return string 'high' | 'low' | 'critical'
     */
    private function get_urgency_status($qty)
    {
        $low_threshold      = get_option('wc_urgency_low_threshold', 10);
        $critical_threshold = get_option('wc_urgency_critical_threshold', 3);

        if ($qty <= $critical_threshold) {
            return 'critical';
        } else if ($qty <= $low_threshold) {
            return 'low';
        }

        return 'high';
    }

    public function enqueue_styles()
    {
        // Only load on single product pages.
        if (! is_product()) {
            return;
        }

        wp_enqueue_style(
            'wc-urgency-frontend',
            WC_URGENCY_URL . 'assets/css/frontend.css',
            array(),
            WC_URGENCY_VERSION
        );
    }
}
