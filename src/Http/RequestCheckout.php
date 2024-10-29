<?php

namespace Basketin\WoocommercePlugin\Http;

class RequestCheckout
{
    private $client;

    public function __construct(Request $request)
    {
        $this->client = $request;
    }

    public function review()
    {
        return $this->client->request('checkout/review', []);
    }

    public function thankyou($order_id, string $anme, string $email, string $phone, string $country)
    {
        return $this->client->request('checkout', [
            'order_id' => $order_id,
            'name' => $anme,
            'email' => $email,
            'phone' => $phone,
            'country' => $country,
        ]);
    }
}
