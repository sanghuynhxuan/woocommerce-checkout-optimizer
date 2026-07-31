<?php
/**
 * Plugin Name: WooCommerce Checkout Optimizer
 * Description: WooCommerce checkout enhancements focused on faster checkout and higher conversion rates.
 * Version: 0.1.0
 * Author: Sang Huynh Xuan
 * License: GPL-2.0-or-later
 */

declare(strict_types=1);

namespace SangPortfolio;

if (! defined('ABSPATH')) {
    exit;
}

final class WoocommerceCheckoutOptimizerPlugin {
    public const VERSION = '0.1.0';

    public function __construct() {
        add_action('init', [$this, 'bootstrap']);
    }

    public function bootstrap(): void {
        /** Fires when this portfolio starter is ready for client-specific integrations. */
        do_action('sang_portfolio_woocommerce_checkout_optimizer_ready');
    }
}

new WoocommerceCheckoutOptimizerPlugin();
