<?php

namespace MailOptin\Libsodium;


use MailOptin\Core\Admin\Customizer\CustomControls\ControlsHelpers;
use MailOptin\Core\Admin\Customizer\CustomControls\WP_Customize_Chosen_Select_Control;
use MailOptin\Core\Admin\Customizer\CustomControls\WP_Customize_Toggle_Control;
use MailOptin\Core\Admin\Customizer\OptinForm\AbstractCustomizer;
use MailOptin\Core\Admin\Customizer\OptinForm\Customizer;
use MailOptin\Core\Admin\Customizer\OptinForm\CustomizerSettings;
use MailOptin\Core\Repositories\OptinCampaignsRepository as OCR;

class WooCommerceTargeting
{
    public $customizer_section_id = 'mo_wp_woocommerce_display_rule_section';

    public function __construct()
    {
        add_action('woocommerce_loaded', function () {
            add_filter('mo_optin_customizer_sections_ids', [$this, 'active_sections'], 10, 2);
            add_action('mo_optin_after_page_user_targeting_display_rule_section', [$this, 'woocommerce_section'], 2, 2);

            add_filter('mo_optin_form_customizer_output_settings', [$this, 'woocommerce_settings'], 10, 2);
            add_action('mo_optin_after_customizer_controls', [$this, 'woocommerce_controls'], 10, 4);

            add_filter('mailoptin_page_targeting_optin_rule', [$this, 'page_targeting_rule'], 10, 2);
        });
    }

    /**
     * @param \WP_Customize_Manager $wp_customize
     * @param Customizer $customizerClassInstance
     */
    public function woocommerce_section($wp_customize, $customizerClassInstance)
    {
        $wp_customize->add_section($this->customizer_section_id, array(
                'title' => esc_html__("Woocommerce Targeting", 'mailoptin'),
                'panel' => $customizerClassInstance->display_rules_panel_id
            )
        );
    }

    public function active_sections($sections)
    {
        $sections[] = $this->customizer_section_id;

        return $sections;
    }

    public function page_targeting_rule($status, $id)
    {
        $checks = [
            'woocommerce_show_specific_woo_products'   => [],
            'woocommerce_show_specific_categories'     => [],
            'woocommerce_show_all_woo_pages'           => ['is_woocommerce'],
            'woocommerce_show_woo_shop'                => ['is_shop'],
            'woocommerce_show_woo_products'            => ['is_product'],
            'woocommerce_show_cart_page'               => ['is_cart'],
            'woocommerce_show_checkout_page'           => ['is_checkout'],
            'woocommerce_show_account_pages'           => ['is_account_page'],
            'woocommerce_show_all_endpoints'           => ['is_wc_endpoint_url'],
            'woocommerce_show_order_pay_endpoint'      => ['is_wc_endpoint_url', 'order-pay'],
            'woocommerce_show_order_received_endpoint' => ['is_wc_endpoint_url', 'order-received'],
            'woocommerce_show_view_order_endpoint'     => ['is_wc_endpoint_url', 'view-order']
        ];

        foreach ($checks as $field => $callback) {
            $value = $post_categories_hide = OCR::get_customizer_value($id, $field);

            if (empty($value)) continue;

            if ($field == 'woocommerce_show_specific_woo_products') {
                if (is_product() && is_array($value)) {
                    $product_id = wc_get_product()->get_id();
                    if (in_array($product_id, $value)) return true;
                }
                continue;
            }

            if ($field == 'woocommerce_show_specific_categories') {
                if (is_product() && is_array($value)) {
                    $post_categories = wc_get_product()->get_category_ids();
                    $intersect       = array_intersect($post_categories, $value);
                    if ( ! empty($intersect)) return true;
                }
                continue;
            }

            if (call_user_func_array(array_shift($callback), $callback)) return true;
        }

        return $status;
    }

    /**
     * @param $settings
     * @param CustomizerSettings $customizerSettings
     *
     * @return mixed
     */
    public function woocommerce_settings($settings, $customizerSettings)
    {
        $customizer_defaults = (new AbstractCustomizer())->customizer_defaults;

        $settings['woocommerce_show_all_woo_pages'] = array(
            'default'   => false,
            'type'      => 'option',
            'transport' => 'postMessage',
        );

        $settings['woocommerce_show_woo_shop'] = array(
            'default'   => false,
            'type'      => 'option',
            'transport' => 'postMessage',
        );

        $settings['woocommerce_show_woo_products'] = array(
            'default'   => false,
            'type'      => 'option',
            'transport' => 'postMessage',
        );

        $settings['woocommerce_show_specific_woo_products'] = array(
            'default'   => '',
            'type'      => 'option',
            'transport' => 'postMessage',
        );

        $settings['woocommerce_show_cart_page'] = array(
            'default'   => false,
            'type'      => 'option',
            'transport' => 'postMessage',
        );

        $settings['woocommerce_show_checkout_page'] = array(
            'default'   => false,
            'type'      => 'option',
            'transport' => 'postMessage',
        );

        $settings['woocommerce_show_account_pages'] = array(
            'default'   => false,
            'type'      => 'option',
            'transport' => 'postMessage',
        );

        $settings['woocommerce_show_all_endpoints'] = array(
            'default'   => false,
            'type'      => 'option',
            'transport' => 'postMessage',
        );

        $settings['woocommerce_show_order_pay_endpoint'] = array(
            'default'   => false,
            'type'      => 'option',
            'transport' => 'postMessage',
        );

        $settings['woocommerce_show_specific_categories'] = array(
            'default'   => false,
            'type'      => 'option',
            'transport' => 'postMessage',
        );

        $settings['woocommerce_show_order_received_endpoint'] = array(
            'default'   => false,
            'type'      => 'option',
            'transport' => 'postMessage',
        );

        $settings['woocommerce_show_view_order_endpoint'] = array(
            'default'   => false,
            'type'      => 'option',
            'transport' => 'postMessage',
        );

        return $settings;
    }

    /**
     * Click Launch display rule.
     *
     * @param \WP_Customize_Manager $wp_customize
     * @param string $option_prefix
     * @param Customizer $customizerClassInstance
     */
    public function woocommerce_controls($instance, $wp_customize, $option_prefix, $customizerClassInstance)
    {
        $woocommerce_control_args = apply_filters(
            "mo_optin_form_customizer_woocommerce_controls",
            array(
                'woocommerce_show_all_woo_pages'           => new WP_Customize_Toggle_Control(
                    $wp_customize,
                    $option_prefix . '[woocommerce_show_all_woo_pages]',
                    array(
                        'label'       => esc_html__('Show on all WC pages', 'mailoptin'),
                        'section'     => $this->customizer_section_id,
                        'settings'    => $option_prefix . '[woocommerce_show_all_woo_pages]',
                        'description' => esc_html__('Enable to show on pages where WooCommerce templates are used. This is usually Shop and product pages as well as archives such as product categories and tags archive pages.', 'mailoptin'),
                        'type'        => 'flat',// light, ios, flat
                        'priority'    => 20
                    )
                ),
                'woocommerce_show_woo_shop'                => new WP_Customize_Toggle_Control(
                    $wp_customize,
                    $option_prefix . '[woocommerce_show_woo_shop]',
                    array(
                        'label'       => esc_html__('Show on WooCommerce shop', 'mailoptin'),
                        'section'     => $this->customizer_section_id,
                        'settings'    => $option_prefix . '[woocommerce_show_woo_shop]',
                        'description' => esc_html__('Enable to show on the shop page (product archive page).', 'mailoptin'),
                        'type'        => 'flat',// light, ios, flat
                        'priority'    => 30
                    )
                ),
                'woocommerce_show_woo_products'            => new WP_Customize_Toggle_Control(
                    $wp_customize,
                    $option_prefix . '[woocommerce_show_woo_products]',
                    array(
                        'label'       => esc_html__('Show on all WC products', 'mailoptin'),
                        'section'     => $this->customizer_section_id,
                        'settings'    => $option_prefix . '[woocommerce_show_woo_products]',
                        'description' => esc_html__('Enable to show on any single product page.', 'mailoptin'),
                        'type'        => 'flat',// light, ios, flat
                        'priority'    => 40
                    )
                ),
                'woocommerce_show_specific_woo_products'   => new WP_Customize_Chosen_Select_Control(
                    $wp_customize,
                    $option_prefix . '[woocommerce_show_specific_woo_products]',
                    array(
                        'label'       => __('Show optin specifically on'),
                        'section'     => $this->customizer_section_id,
                        'settings'    => $option_prefix . '[woocommerce_show_specific_woo_products]',
                        'description' => esc_html__('Show only on selected single products pages.', 'mailoptin'),
                        'search_type' => 'woocommerce_products',
                        'choices'     => ControlsHelpers::get_post_type_posts('product'),
                        'priority'    => 50
                    )
                ),
                'woocommerce_show_specific_categories'     => new WP_Customize_Chosen_Select_Control(
                    $wp_customize,
                    $option_prefix . '[woocommerce_show_specific_categories]',
                    array(
                        'label'       => __('Show on product categories'),
                        'section'     => $this->customizer_section_id,
                        'settings'    => $option_prefix . '[woocommerce_show_specific_categories]',
                        'description' => esc_html__('Show only on selected WooCommerce products categories.', 'mailoptin'),
                        'choices'     => ControlsHelpers::get_terms('product_cat'),
                        'priority'    => 55
                    )
                ),
                'woocommerce_show_cart_page'               => new WP_Customize_Toggle_Control(
                    $wp_customize,
                    $option_prefix . '[woocommerce_show_cart_page]',
                    array(
                        'label'       => esc_html__('Show on WooCommerce cart', 'mailoptin'),
                        'section'     => $this->customizer_section_id,
                        'settings'    => $option_prefix . '[woocommerce_show_cart_page]',
                        'description' => esc_html__('Enable to show on WooCommerce cart page.', 'mailoptin'),
                        'type'        => 'flat',// light, ios, flat
                        'priority'    => 60
                    )
                ),
                'woocommerce_show_checkout_page'           => new WP_Customize_Toggle_Control(
                    $wp_customize,
                    $option_prefix . '[woocommerce_show_checkout_page]',
                    array(
                        'label'       => esc_html__('Show on WC checkout', 'mailoptin'),
                        'section'     => $this->customizer_section_id,
                        'settings'    => $option_prefix . '[woocommerce_show_checkout_page]',
                        'description' => esc_html__('Enable to show on WooCommerce checkout page.', 'mailoptin'),
                        'type'        => 'flat',// light, ios, flat
                        'priority'    => 70
                    )
                ),
                'woocommerce_show_account_pages'           => new WP_Customize_Toggle_Control(
                    $wp_customize,
                    $option_prefix . '[woocommerce_show_account_pages]',
                    array(
                        'label'       => esc_html__('Show on WC customer account', 'mailoptin'),
                        'section'     => $this->customizer_section_id,
                        'settings'    => $option_prefix . '[woocommerce_show_account_pages]',
                        'description' => esc_html__('Enable to show on WooCommerce customer account pages.', 'mailoptin'),
                        'type'        => 'flat',// light, ios, flat
                        'priority'    => 80
                    )
                ),
                'woocommerce_show_all_endpoints'           => new WP_Customize_Toggle_Control(
                    $wp_customize,
                    $option_prefix . '[woocommerce_show_all_endpoints]',
                    array(
                        'label'       => esc_html__('Show on any WC Endpoints', 'mailoptin'),
                        'section'     => $this->customizer_section_id,
                        'settings'    => $option_prefix . '[woocommerce_show_all_endpoints]',
                        'description' => esc_html__('Enable to show when on any WooCommerce Endpoint.', 'mailoptin'),
                        'type'        => 'flat',// light, ios, flat
                        'priority'    => 90
                    )
                ),
                'woocommerce_show_view_order_endpoint'     => new WP_Customize_Toggle_Control(
                    $wp_customize,
                    $option_prefix . '[woocommerce_show_view_order_endpoint]',
                    array(
                        'label'       => esc_html__('Show on View Order endpoint', 'mailoptin'),
                        'section'     => $this->customizer_section_id,
                        'settings'    => $option_prefix . '[woocommerce_show_view_order_endpoint]',
                        'description' => esc_html__('Enable to show when the endpoint page for view order is displayed.', 'mailoptin'),
                        'type'        => 'flat',// light, ios, flat
                        'priority'    => 95
                    )
                ),
                'woocommerce_show_order_pay_endpoint'      => new WP_Customize_Toggle_Control(
                    $wp_customize,
                    $option_prefix . '[woocommerce_show_order_pay_endpoint]',
                    array(
                        'label'       => esc_html__('Show on Order Pay endpoint', 'mailoptin'),
                        'section'     => $this->customizer_section_id,
                        'settings'    => $option_prefix . '[woocommerce_show_order_pay_endpoint]',
                        'description' => esc_html__('Enable to show when the endpoint page for order pay is displayed.', 'mailoptin'),
                        'type'        => 'flat',// light, ios, flat
                        'priority'    => 100
                    )
                ),
                'woocommerce_show_order_received_endpoint' => new WP_Customize_Toggle_Control(
                    $wp_customize,
                    $option_prefix . '[woocommerce_show_order_received_endpoint]',
                    array(
                        'label'       => esc_html__('Show on Order Received endpoint', 'mailoptin'),
                        'section'     => $this->customizer_section_id,
                        'settings'    => $option_prefix . '[woocommerce_show_order_received_endpoint]',
                        'description' => esc_html__('Enable to show when the endpoint page for order received or thank you page is displayed.', 'mailoptin'),
                        'type'        => 'flat',// light, ios, flat
                        'priority'    => 110
                    )
                )
            ),
            $wp_customize,
            $option_prefix,
            $customizerClassInstance
        );

        do_action('mailoptin_before_woocommerce_controls_addition');

        foreach ($woocommerce_control_args as $id => $args) {
            if (is_object($args)) {
                $wp_customize->add_control($args);
            } else {
                $wp_customize->add_control($option_prefix . '[' . $id . ']', $args);
            }
        }

        do_action('mailoptin_after_woocommerce_controls_addition');
    }

    /**
     * Singleton poop.
     *
     * @return self
     */
    public static function get_instance()
    {
        static $instance = null;

        if (is_null($instance)) {
            $instance = new self();
        }

        return $instance;
    }
}