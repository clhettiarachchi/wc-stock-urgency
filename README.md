# WC Stock Urgency Notifier

A focused WooCommerce plugin that displays a dynamic, colour-coded stock urgency message on single product pages.

Built as a portfolio project to demonstrate WooCommerce hook knowledge, WP Settings API usage, clean BEM CSS, and plugin architecture best practices.

## Installation

1. Download or clone this repo into `wp-content/plugins/wc-stock-urgency/`
2. Run `npm install` then `npx gulp build` to compile the CSS
3. Activate the plugin from WP Admin → Plugins
4. Configure thresholds at WooCommerce → Stock Urgency

---

## Settings

| Setting                  | Default | Description                                     |
| ------------------------ | ------- | ----------------------------------------------- |
| Low Stock Threshold      | 10      | Stock at or below this level shows amber notice |
| Critical Stock Threshold | 3       | Stock at or below this level shows red notice   |

---

## How it works

| Stock level                    | Message                        | Colour |
| ------------------------------ | ------------------------------ | ------ |
| Above low threshold            | In stock and ready to ship     | Green  |
| At or below low threshold      | Only X left in stock           | Amber  |
| At or below critical threshold | Last X remaining — order soon! | Red    |

Notice is hidden when:

- Stock management is disabled on the product
- Product is out of stock
- Product is a variable product parent

---

## Hooks Reference

| Hook                                 | Type   | Used in  | Purpose                           |
| ------------------------------------ | ------ | -------- | --------------------------------- |
| `woocommerce_single_product_summary` | action | Frontend | Inject notice into product page   |
| `plugin_action_links_{basename}`     | filter | Admin    | Add Settings link in Plugins list |
| `admin_menu`                         | action | Admin    | Register settings page            |
| `admin_init`                         | action | Admin    | Register settings and fields      |
| `wp_enqueue_scripts`                 | action | Frontend | Enqueue CSS on product pages only |

---

## Gulp commands

| Command          | What it does                         |
| ---------------- | ------------------------------------ |
| `npx gulp`       | Compile once, then watch for changes |
| `npx gulp build` | Compile once only                    |
