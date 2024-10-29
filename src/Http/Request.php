<?php

namespace Basketin\WoocommercePlugin\Http;

use Basketin\WoocommercePlugin\Config;
use Basketin\WoocommercePlugin\CustomerIdentity;

class Request
{
    private $base_url;
    private $headers;

    public $requestActivation;

    public function __construct(
        Config $config,
        CustomerIdentity $identity
    ) {
        $this->base_url = $config->base_url . $config->basket . '/';
        $this->headers = [
            'Authorization' => 'Bearer ' . $config->token,
            'x-basketin-customer-identity' => $identity->getIdentity(),
            'x-basketin-visitor-ip' => $config->customer_ip_address,
        ];

        $this->requestActivation = new RequestActivation($config, $this);
    }

    /**
     * Generator request
     */
    public function request($uri = '', $body = [])
    {
        return wp_remote_post($this->base_url . $uri, [
            'method' => 'POST',
            'timeout' => 45,
            'httpversion' => '1.0',
            'blocking' => true,
            'headers' => $this->headers,
            'body' => $body,
        ]);
    }

    public function addToCart(string $cart_item_key, int $product_id, int $quantity, $price, $product = [])
    {
        $this->request('add-to-cart', [
            'cart_item_key' => $cart_item_key,
            'product_id' => $product_id,
            'quantity' => $quantity,
            'price' => $price,
            'product' => $product,
        ]);
    }

    public function RemoveFromCart(string $cart_item_key, int $product_id)
    {
        $this->request('remove-from-cart', [
            'cart_item_key' => $cart_item_key,
            'product_id' => $product_id,
        ]);
    }

    public function updateCart($data)
    {
        $this->request('update-cart', [
            'data' => $data,
        ]);
    }

    public function checkout()
    {
        return new RequestCheckout($this);
    }
}
