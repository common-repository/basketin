<?php

namespace Basketin\WoocommercePlugin\Activation;

use Basketin\WoocommercePlugin\Cart\CartGeneratorHash;
use Basketin\WoocommercePlugin\Config;
use Basketin\WoocommercePlugin\Http\Request;

class ActivationManagement
{
    private $request;

    public function __construct(
        Config $config,
        CartGeneratorHash $cart_hash
    ) {
        $this->request = new Request($config, $cart_hash);

        register_activation_hook($config->file_plugin, array($this, 'action_register_activation_hook'));
        register_deactivation_hook($config->file_plugin, array($this, 'action_register_deactivation_hook'));
    }

    public function action_register_activation_hook()
    {
        $this->request->requestActivation->activation();
    }

    public function action_register_deactivation_hook()
    {
        $this->request->requestActivation->deactivation();
    }
}
