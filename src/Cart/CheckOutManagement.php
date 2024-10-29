<?php

namespace Basketin\WoocommercePlugin\Cart;

use Basketin\WoocommercePlugin\Config;
use Basketin\WoocommercePlugin\CustomerIdentity;
use Basketin\WoocommercePlugin\Http\Request;

class CheckOutManagement
{
    private $request;

    public function __construct(
        Config $config,
        CustomerIdentity $identity
    ) {
        $this->request = new Request($config, $identity);

        // add_filter('woocommerce_order_button_html', [$this, 'action_woocommerce_checkout_order_review']);
        add_action('woocommerce_thankyou', [$this, 'action_woocommerce_thankyou'], 10, 1);
    }

    public function action_woocommerce_checkout_order_review($order_button)
    {
        if (is_checkout() && get_option('basketin_armor_mode', 'no') == 'yes') {
            $response = $this->request->checkout()->review();

            $body = json_decode(wp_remote_retrieve_body($response), true);

            return ($body['is_block']) ? 'You cannot create a new order.' : $order_button;
        }

        return $order_button;
    }

    public function action_woocommerce_thankyou($order_id)
    {
        $order = wc_get_order($order_id);

        $response = $this->request->checkout()->thankyou($order_id, $order->get_billing_first_name() . ' ' . $order->get_billing_last_name(), $order->get_billing_email(), $order->get_billing_phone(), $order->get_billing_country());

        $body = json_decode(wp_remote_retrieve_body($response), true);

        if (get_option('basketin_armor_mode', 'no') == 'yes') {
            if ($body['is_suspected']) {
                $order->update_status('wc-suspected-status');
            }
        }
    }
}
