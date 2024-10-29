<?php

namespace Basketin\WoocommercePlugin\Http;

use Basketin\WoocommercePlugin\Config;

class RequestActivation
{
    private $config;
    private $client;

    public function __construct(Config $config, Request $request)
    {
        $this->config = $config;
        $this->client = $request;
    }

    public function activation()
    {
        $this->client->request('activation/activation', [
            'basket' => $this->config->basket,
        ]);
    }

    public function deactivation()
    {
        $this->client->request('activation/deactivation', [
            'basket' => $this->config->basket,
            'ac' => 'deactivation'
        ]);
    }
}