<?php

namespace Basketin\WoocommercePlugin;

use Basketin\WoocommercePlugin\Cart\CartManagement;
use Basketin\WoocommercePlugin\Cart\CheckOutManagement;

class Manage
{
    private $config;
    private $identity;

    public function __construct(Config $config, CustomerIdentity $identity)
    {
        $this->config = $config;
        $this->identity = $identity;
    }

    public function run()
    {

        (new WC_Settings_Basketin)->init();

        new CartManagement($this->config, $this->identity);
        new CheckOutManagement($this->config, $this->identity);
    }
}
