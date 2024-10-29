<?php

namespace Basketin\WoocommercePlugin;

class CustomerIdentity
{
    private $nameCookie = 'basketin_customer_identity';

    private $identity;

    public function __construct()
    {
        $this->identity = uniqid();

        if (!isset($_COOKIE[$this->nameCookie])) {
            setcookie($this->nameCookie, $this->identity, strtotime("+1 year"), '/');
        }
    }

    public function getIdentity(): string
    {
        if (isset($_COOKIE[$this->nameCookie])) {
            return $_COOKIE[$this->nameCookie];
        }

        return $this->identity;
    }
}
