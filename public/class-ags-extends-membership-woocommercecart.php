<?php 

class WoocommerceCart {
	private static $instance;

	public $items;

	/**
	 * Returns an instance of this class. 
	 */
	public static function get_instance() {

		if ( null == self::$instance ) {
			self::$instance = new WoocommerceCart();
		} 

		return self::$instance;

	} 

	/**
	 * Initializes the plugin by setting filters and administration functions.
	 */
	public function __construct() {
		add_action( 'wp_head', [ $this, 'clearCart' ] );
		add_filter( 'wc_add_to_cart_message_html', '__return_null' );
	}

	public function clearCart(){
		if (is_admin()) {
			return;
		}
		if ( wc_get_page_id( 'cart' ) == get_the_ID() || wc_get_page_id( 'checkout' ) == get_the_ID() ) {
		return;
		}
		WC()->cart->empty_cart( true );
	}
}