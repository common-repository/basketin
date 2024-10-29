<?php

namespace Basketin\WoocommercePlugin\Cart;

use Basketin\WoocommercePlugin\Config;
use Basketin\WoocommercePlugin\CustomerIdentity;
use Basketin\WoocommercePlugin\Http\Request;

class CartManagement
{
    private $request;

    public function __construct(
        Config $config,
        CustomerIdentity $identity
    ) {
        $this->request = new Request($config, $identity);

        add_action('woocommerce_add_to_cart', [$this, 'action_woocommerce_add_to_cart'], 10, 3);
        // add_action('woocommerce_remove_cart_item', [$this, 'action_woocommerce_remove_cart_item'], 10, 2);
        // add_filter('woocommerce_update_cart_action_cart_updated', [$this, 'filter_woocommerce_update_cart_action_cart_updated'], 10, 1);
    }

    public function action_woocommerce_add_to_cart($cart_item_key,  $product_id,  $quantity)
    {
        $product = wc_get_product($product_id);
        $image = wp_get_attachment_image_src(get_post_thumbnail_id($product_id), 'single-post-thumbnail')[0];
        $this->request->addToCart($cart_item_key, $product_id, $quantity, $product->get_price(), [
            'name' => $product->get_name(),
            'image_url' => $image,
        ]);
    }

    public function action_woocommerce_remove_cart_item($cart_item_key, $instance)
    {
        $product_id = $instance->cart_contents[$cart_item_key]['product_id'];
        $this->request->RemoveFromCart($cart_item_key, $product_id);
    }

    function filter_woocommerce_update_cart_action_cart_updated($cart_updated)
    {
        if (!empty($cart_updated)) {
            $cart_items = WC()->cart->get_cart();

            $data = [];
            foreach ($cart_items as $item) {
                $data[] = [
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                ];
            }

            $this->request->updateCart($data);
        }
    }
}
