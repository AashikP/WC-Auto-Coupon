=== WC Auto Coupon ===
Contributors: aashik
Tags: woocommerce, order, coupon, order amount, order total, minimum order, auto coupon, cart, checkout, woo
Requires at least: 5.3.2
Tested up to: 5.3.2
Stable tag: 1.0.0
Requires PHP: 7.2
WC requires at least: 4.0.1
WC tested up to: 4.0.1
License: GPLv3 or later License
URI: http://www.gnu.org/licenses/gpl-3.0.html

Automatically apply coupon when the cart total exceeds the minimum amount defined..

== Description ==

By configuring the minimum amount for an order, your manually created coupon will be automatically applied to those customers's order that meets the minimum requirement specified.


== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/wc-auto-coupon` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Use the WooCommerce > Settings > General tab (Scroll to the bottom of the page to find the settings)


== Frequently Asked Questions ==

= Does this plugin automatically create the coupon? =

No, a coupon needs to be created manually as per the instructions in [Coupon Management Documentation](https://docs.woocommerce.com/document/coupon-management/).

= Where do I configure the plugin settings? =

You can find the options under: WooCommerce > Settings > General > Scroll down to the bottom of the page to find `WC Auto Coupon Settings`.

= Why is the coupon not applied even though the minimum order requirement is met? =

The coupon will only be applied if it is valid for an order. For example, if you have restrictions or limitations set up, the coupon won't be applied. Please check if:

* Coupon has no usage restrictions
* Coupon has not reached its limit 
(total number of uses)
* Coupon has an expity date in the future

= Is this compatible with other plugins that deal with discounts? = 

This extension is only tested with core WooCommerce features. I'm not sure if this works with other extensions. While I cannot  promise compatibility with other plugins, please feel free to report it here: 

== Screenshots ==

1. WC Auto Coupons Settings
2. Default Cart/Checkout Page message
3. Custom Cart/Checkout Page message

== Changelog ==

= 1.0.0 =
* First Release