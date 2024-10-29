<?php

namespace Basketin\WoocommercePlugin\Admin;

class Dashboard
{
    public function __construct()
    {
        add_action('admin_menu', [$this, 'basketin_panel_menu']);
    }

    public function basketin_panel_menu()
    {
        add_submenu_page('woocommerce', 'BasketIn Setting', __('BasketIn Setting', 'udp'), 'manage_options', 'basketin-panel', [$this, 'basketin_panel']);
    }

    public function basketin_panel()
    {
        if (isset($_POST['submit'])) {

            $basket_key = sanitize_text_field($_POST['basket']);
            $basket_token = sanitize_text_field($_POST['token']);

            if (!get_option('basket_basket', false)) {
                add_option('basket_basket', $basket_key);
            } else {
                update_option('basket_basket', $basket_key);
            }

            if (!get_option('basket_token', false)) {
                add_option('basket_token', $basket_token);
            } else {
                update_option('basket_token', $basket_token);
            }
        }

        include(__DIR__ . '/../Views/woo_setting.php');
    }
}
