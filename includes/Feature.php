<?php
declare(strict_types=1);
namespace SangPortfolio;
if (! defined('ABSPATH')) { exit; }
final class WoocommerceCheckoutOptimizerFeature {
    private const OPTION = 'woocommerce_checkout_optimizer_enabled';
    private const SLUG = 'woocommerce-checkout-optimizer';
    private const TITLE = 'WooCommerce Checkout Optimizer';
    public function register(): void {
        add_action('admin_init', [$this, 'registerSettings']);
        add_action('admin_menu', [$this, 'registerPage']);
        if (Support::enabled(self::OPTION)) { $this->registerFeature(); }
    }
    public function registerSettings(): void { register_setting(self::SLUG, self::OPTION, ['sanitize_callback' => static fn($value): string => empty($value) ? '0' : '1']); }
    public function registerPage(): void { add_options_page(self::TITLE, self::TITLE, 'manage_options', self::SLUG, [$this, 'renderPage']); }
    public function renderPage(): void { if (! current_user_can('manage_options')) { return; } echo '<div class="wrap"><h1>' . esc_html(self::TITLE) . '</h1><form method="post" action="options.php">'; settings_fields(self::SLUG); echo '<label><input type="checkbox" name="' . esc_attr(self::OPTION) . '" value="1" ' . checked(Support::enabled(self::OPTION), true, false) . '> ' . esc_html__('Enable feature', 'sang-portfolio') . '</label>'; submit_button(); echo '</form></div>'; }
    private function registerFeature(): void { add_filter('woocommerce_checkout_fields', [$this, 'streamlineCheckout']); add_action('woocommerce_after_checkout_validation', [$this, 'validatePhone'], 10, 2); }
    public function streamlineCheckout(array $fields): array { if (isset($fields['billing']['billing_company'])) { $fields['billing']['billing_company']['required'] = false; } if (isset($fields['order']['order_comments'])) { $fields['order']['order_comments']['priority'] = 120; } return $fields; } public function validatePhone(array $data, $errors): void { if (! empty($data['billing_phone']) && strlen(preg_replace('/\D/', '', (string) $data['billing_phone'])) < 7) { $errors->add('billing_phone', __('Please enter a valid phone number.', 'sang-portfolio')); } }
}
