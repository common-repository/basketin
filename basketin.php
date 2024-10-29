<?php

use Basketin\WoocommercePlugin\Config;
use Basketin\WoocommercePlugin\CustomerIdentity;
use Basketin\WoocommercePlugin\Manage;

/**
 * Plugin Name: BasketIn Tools
 * Description: Monitoring and analyzing the shopping carts of customers, knowing the abandoned carts, and taking effective action with it.
 * Author: BasketIn Team
 * Version: 0.1.7
 * Author URI: https://basketin.net/
 * 
 * WC requires at least: 6.0
 * WC tested up to: 6.1
 *
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

require __DIR__ . '/vendor/autoload.php';

$config = new Config([
    'basket' => get_option('basket_basket'),
    'token' => get_option('basket_token'),
    'customer_ip_address' => get_ip_address(),
]);

$identity = new CustomerIdentity();

$manage = new Manage($config, $identity);

$manage->run();

function get_ip_address()
{
    foreach (['HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR'] as $key) {
        if (isset($_SERVER[$key])) {
            return $_SERVER[$key];
        }
    }
}

/**
 * Add custom order status to WooCommerce
 */
function add_custom_order_status()
{
    register_post_status('wc-suspected-status', array(
        'label' => 'Suspected Order',
        'public' => true,
        'exclude_from_search' => false,
        'show_in_admin_all_list' => true,
        'show_in_admin_status_list' => true,
        'label_count' => _n_noop('Suspected Order <span class="count">(%s)</span>', 'Suspected Order <span class="count">(%s)</span>')
    ));
}
add_action('init', 'add_custom_order_status');

function add_awaiting_shipment_to_order_statuses($order_statuses)
{
    $order_statuses['wc-suspected-status'] = 'Suspected Order';
    return $order_statuses;
}

add_filter('wc_order_statuses', 'add_awaiting_shipment_to_order_statuses');
