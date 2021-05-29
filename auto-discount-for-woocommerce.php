<?php
/**
 * Plugin Name: Auto Discount for WooCommerce
 * Plugin URI: https://github.com/AashikP/auto-discount-for-woocommerce
 * Description: Automatically apply a discount coupon when the cart total exceeds the minimum amount defined.
 * Version: 1.1.0
 * Author: Aashik P
 * Author URI: https://aashikp.com
 * License: GPLv3 or later License
 * URI: http://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: auto_discount_wc
 * WC requires at least: 4.0.1
 * WC tested up to: 5.3.0
 * Original snippet source: https://docs.woocommerce.com/document/apply-a-coupon-for-minimum-cart-total/
 *
 * @package Auto Discount for WooCommerce
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/* Check if WooCommerce is active */

if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ), true ) ) {

	add_filter( 'woocommerce_general_settings', 'adwc_minimum_order_settings', 10, 2 );

	/**
	 * WooCommerce Auto Coupon Settings (WooCommerce > Settings > General)
	 *
	 * @param array $settings -> Add to WooCommerce Settings.
	 */
	function adwc_minimum_order_settings( $settings ) {

		$settings[] = array(
			'title' => __( 'Auto Discount for WooCommerce Settings', 'auto_discount_wc' ),
			'type'  => 'title',
			'desc'  => 'Set the minimum order amount and coupon to be applied. Also adjust cart and checkout notifications',
			'id'    => 'adwc_settings',
		);

		// Minimum order amount.
		$settings[] = array(
			'title'    => __( 'Minimum order amount', 'auto_discount_wc' ),
			'desc'     => __( 'Set the minimum order amount for the coupon to be applied. If empty, the extension won\'t make any changes to the cart', 'auto_discount_wc' ),
			'id'       => 'adwc_minimum_order_value',
			'default'  => '',
			'type'     => 'number',
			'desc_tip' => true,
			'css'      => 'width:70px;',
		);

		// Coupon to be applied.
		$settings[] = array(
			'title'    => __( 'Coupon to be applied', 'auto_discount_wc' ),
			'desc'     => __( 'Enter the coupon name that needs to be applied for orders of value greater than the minimum order amount defined above. If empty / coupon isn\'t valid, the extension won\'t make any changes to the cart', 'auto_discount_wc' ),
			'id'       => 'adwc_coupon_name',
			'default'  => '',
			'type'     => 'text',
			'desc_tip' => true,
			'css'      => 'width:200px;',
		);

		// Cart / Checkout message before applying the discount.
		$settings[] = array(
			'title'    => __( 'Message prior to applying discount', 'auto_discount_wc' ),
			'desc'     => __( 'Show this message if the current order total is less than the defined minimum. If left empty, default notice will be displayed', 'auto_discount_wc' ),
			'id'       => 'adwc_discount_eligible_notification',
			'default'  => '',
			'type'     => 'textarea',
			'desc_tip' => true,
			'css'      => 'min-width:600px;',
		);

		// Cart / Checkout message after applying the discount.
		$settings[] = array(
			'title'    => __( 'Discount Applied Notification', 'auto_discount_wc' ),
			'desc'     => __( 'Show this message if the current order total is less than the defined minimum. If left empty, default notice will be displayed', 'auto_discount_wc' ),
			'id'       => 'adwc_discount_applied_notification',
			'default'  => '',
			'type'     => 'textarea',
			'desc_tip' => true,
			'css'      => 'min-width:600px;',
		);

		$settings[] = array(
			'type' => 'sectionend',
			'id'   => 'adwc_settings',
		);
		return $settings;
	}

	/* Notices and checks */

	add_action( 'woocommerce_before_cart', 'ap_auto_discount_wc' );
	add_action( 'woocommerce_before_checkout_form', 'ap_auto_discount_wc' );

	/**
	 * Run the function while on cart or checkout page
	 */
	function ap_auto_discount_wc() {

			$minimum_amount        = get_option( 'adwc_minimum_order_value' );
			$coupon                = get_option( 'adwc_coupon_name' );
			$cart_total            = WC()->cart->get_subtotal();
			$currency_code         = get_woocommerce_currency();
			$adwc_notification     = get_option( 'adwc_discount_eligible_notification' );
			$adwc_discount_applied = get_option( 'adwc_discount_applied_notification' );

		// Only proceed if Minimum Order Amount and Coupon to be Applied is defined.
		if ( $minimum_amount && $coupon ) {
			// Create a new object for coupon, and proceed if it is valid.
			$coupon = new WC_Coupon( $coupon );
			if ( $coupon->is_valid() ) {
				$coupon = $coupon->get_code();
				wc_clear_notices();
				// Remove coupon if cart total is < Minimum configured amount.
				if ( $cart_total < $minimum_amount ) {
					WC()->cart->remove_coupon( $coupon );
					// Display generic notice if a custom message is not setup.
					if ( $adwc_notification ) {
						wc_print_notice( "$adwc_notification", 'notice' );
					} else {
						wc_print_notice( "Get a discount if you spend more than $minimum_amount $currency_code!", 'notice' );
					}
				} else { // Apply coupon if cart total is > Minimum configured amount.
					WC()->cart->apply_coupon( $coupon );
					// Display generic notice if a custom message is not setup.
					if ( $adwc_discount_applied ) {
						wc_print_notice( "$adwc_discount_applied", 'notice' );
					} else {
						wc_print_notice( 'Discount Applied!', 'notice' );
					}
				}
				wc_clear_notices();
			}
		}
	}
}
