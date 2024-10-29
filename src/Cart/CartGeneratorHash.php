<?php

namespace Basketin\WoocommercePlugin\Cart;

class CartGeneratorHash
{
    private $name_cookie = 'basketin_cart_hash';

    private $hash;

    private $time;

    public function __construct()
    {
        $this->hash = md5(time());

        $this->time = strtotime("+1 year");

        if (!isset($_COOKIE[$this->name_cookie])) {
            setcookie($this->name_cookie, $this->hash, $this->time, '/');
        }
    }

    public function refreshHash(): void
    {
        if (isset($_COOKIE[$this->name_cookie])) {
            setcookie($this->name_cookie, $this->hash, $this->time, '/');
        }
    }

    public function getHash(): string
    {
        if (isset($_COOKIE[$this->name_cookie])) {
            return $_COOKIE[$this->name_cookie];
        }

        return $this->hash;
    }
}
