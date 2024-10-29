<?php

namespace Basketin\WoocommercePlugin;

class WC_Settings_Basketin
{
    public function init()
    {
        add_filter('woocommerce_settings_tabs_array', [$this, 'add_settings_tab'], 50);
        add_action('woocommerce_settings_tabs_basketin_settings', [$this, 'settings_tab']);
        add_action('woocommerce_update_options_basketin_settings', [$this, 'update_settings']);
    }

    public function add_settings_tab($settings_tabs)
    {
        $settings_tabs['basketin_settings'] = __('Basketin settings', 'woocommerce-settings-tab-basketin');
        return $settings_tabs;
    }

    public function settings_tab()
    {
        woocommerce_admin_fields($this->get_settings());
    }

    public function update_settings()
    {
        woocommerce_update_options($this->get_settings());
    }

    public function get_settings()
    {

        $settings = array(
            'section_title' => array(
                'name'     => __('Basketin settings', 'woocommerce-settings-tab-basketin'),
                'type'     => 'title',
                'desc'     => '',
                'id'       => 'wc_settings_basketin_section_title'
            ),

            'basket' => array(
                'name' => __('Basket', 'woocommerce-settings-tab-basketin'),
                'type' => 'text',
                'desc' => __('This is some helper text', 'woocommerce-settings-tab-basketin'),
                'id'   => 'basket_basket'
            ),

            'token' => array(
                'name' => __('Basket Token', 'woocommerce-settings-tab-basketin'),
                'type' => 'text',
                'desc' => __('This is some helper text', 'woocommerce-settings-tab-basketin'),
                'id'   => 'basket_token'
            ),

            'check' => array(
                'name' => __('Basketin Armor Mode', 'woocommerce-settings-tab-basketin'),
                'type' => 'checkbox',
                'desc' => __('You can activate the armors mode for protection', 'woocommerce-settings-tab-basketin'),
                'id'   => 'basketin_armor_mode'
            ),

            'section_end' => array(
                'type' => 'sectionend',
                'id' => 'wc_basketin_settings_section_end'
            )
        );

        return apply_filters('wc_basketin_settings_settings', $settings);
    }
}
