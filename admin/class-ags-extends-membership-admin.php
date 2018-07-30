<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       www.agenciadosite.com.br
 * @since      1.0.0
 *
 * @package    Ags_Extends_Membership
 * @subpackage Ags_Extends_Membership/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Ags_Extends_Membership
 * @subpackage Ags_Extends_Membership/admin
 * @author     Rafael Figueiredo <suporte@agenciadosite.com.br>
 */
class Ags_Extends_Membership_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * The status woocommerce
	 * @since    1.0.0
	 * @access   private
	 * @var      boolean    $version    Check if woocomerce is activated.
	 */
	private $woocommerce_status;

	/**
	 * The status inspiry_membership
	 * @since    1.0.0
	 * @access   private
	 * @var      boolean    $version    Check if inspiry_membership is activated.
	 */
	private $inspiry_membership_status;

	/**
	 * The status inspiry_membership
	 * @since    1.0.0
	 * @access   private
	 * @var      boolean    $version    Check if inspiry_membership is activated.
	 */
	private $ims;

	/**
	 * The status inspiry_membership
	 * @since    1.0.0
	 * @access   private
	 * @var      boolean    $version    Check if inspiry_membership is activated.
	 */
	private $xdebug;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		include_once WP_PLUGIN_DIR .'/inspiry-memberships/inspiry-memberships.php';

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->woocommerce_status = $this->check_woocommerce_is_installed();
		$this->inspiry_membership_status = $this->check_inspiry_membership_is_installed();
		$this->ims = ims();
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ags_Extends_Membership_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ags_Extends_Membership_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ags-extends-membership-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ags_Extends_Membership_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ags_Extends_Membership_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ags-extends-membership-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function check_woocommerce_is_installed(){
		/**
		 * This function check if woocommerce is installed
		 */
		if ( in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
			return true;
		} else {
			return false;
		}
	}

	public function woocommerce_is_not_installed(){
		/**
		 * This function show a message if woocommerce is not installed
		 */
		if($this->woocommerce_status !== true){
			include plugin_dir_path( __FILE__ ) . 'partials/ags-extends-membership-admin-woocommerce-warning.php';
		}
	}

	public function check_inspiry_membership_is_installed(){
		/**
		 * This function check if inspirymembership is installed
		 */
		if ( in_array('inspiry-memberships/inspiry-memberships.php', apply_filters('active_plugins', get_option('active_plugins')))) {
			return true;
		} else {
			return false;
		}
	}

	public function inspiry_membership_is_not_installed(){
		/**
		 * This function show a message if inspirymembership is not installed
		 */
		if($this->inspiry_membership_status !== true){
			include plugin_dir_path( __FILE__ ) . 'partials/ags-extends-membership-admin-inspiry-memberships-warning.php';
		}
	}

	public function ims(){
		$receipt_methods 	= new IMS_Receipt_Method();
		$membership_methods	= new IMS_Membership_Method();
		$ims_functions = IMS_Functions();
		//$membership_methods->update_user_membership('29', '5434', 'paypal');
	}

	public function create_select_membership($user){
		$ims_functions = IMS_Functions();
		$all_memberships = $ims_functions->ims_get_all_memberships();
		$user_membership = $ims_functions->ims_get_membership_by_user($user);
		$options .= '<select id="select_membership" name="select_membership"><option id="0">Sem plano</option>';
		$selected = '';
		for ($i=0; $i < count($all_memberships); $i++) { 
			if($all_memberships[$i]['title'] == $user_membership['title'] ){
				$selected = 'selected="selected"';
			}

			$options .= sprintf("<option value='%s' %s>%s</option>", $all_memberships[$i]['ID'], $selected, $all_memberships[$i]['title']);
			$selected = '';
		}
		$options .= '</select>';
		
		return $options;
	}

	public function update_membership_field( $user_id ){
			$membership_methods	= new IMS_Membership_Method();
		if ($_POST['select_membership'] != 0) {
			$membership_methods->update_user_membership($user_id, $_POST['select_membership'], 'paypal');
			return;
		}
			$meta_value_data = (int)get_user_meta($user_id, 'ims_current_membership', true);
			$membership_methods->cancel_user_membership($user_id, $meta_value_data);
			//update_user_meta($user_id, 'ims_current_membership', $meta_value_data);
	}

	public function crf_registration_errors( $errors, $sanitized_user_login, $user_email ) {
	if ( $update ) {
		return;
	}
	$errors->add( 'select_membership_error', __( '<strong>ERROR</strong>: Aconteceu algum erro', 'crf' ) );

	return $errors;
	}
	
	public function membership_field( $user ){
		$selectMemberShip = $this->create_select_membership($user);
		include plugin_dir_path( __FILE__ ) . 'partials/ags-extends-membership-admin-membership-field.php';
	}

	public function create_membership_woocommerce_field(){
		$options = array();
		$options += ['0' => 'Sem plano'];
		$ims_functions = IMS_Functions();
		$all_memberships = $ims_functions->ims_get_all_memberships();
		for ($i=0; $i < count($all_memberships); $i++) { 
			$options += [ $all_memberships[$i]['ID'] => $all_memberships[$i]['title']];
		}
		//var_dump($options);
	  woocommerce_wp_select( 
	    array( 
	      'id' => '_membership', 
	      'label' => __( 'Plano atrelado', 'woocommerce' ), 
	      'options' => $options
	    )
	  );

	  $order = wc_get_order( 5684 );
	  $items = $order->get_items();
	  $product_id = $items[1]['product_id'];

	  $get_product_membership = get_post_meta($product_id, '_membership', true);
	}

	public function save_membership_woocommerce_field( $post_id ){
		$membership = $_POST['_membership'];
		update_post_meta( $post_id, '_membership', esc_attr( $membership ) );
	}


	public function create_memberplan_after_status_complete(){
		/*$membership_methods	= new IMS_Membership_Method();
		$membership_methods->cancel_user_membership('29', '5434');
*/		
		global $post;
		$order = wc_get_order( $post->ID );
		$this->xdebug = $order;
		//I can use wc-order.php e abstract-wc-order.php functions
		$items = array_values($order->get_items());
		$customer = $order->get_customer_id();
		$product_id = $items[0]['product_id'];
		//wp_die(var_dump($product_id));
		$product_membership = get_post_meta($product_id, '_membership', true);

		$membership_methods	= new IMS_Membership_Method();
		$membership_methods->update_user_membership($customer, $product_membership, 'paypal');
	}

	public function create_memberplan_after_update_order($order){
		$order = wc_get_order($order);
		if ($order->data['status'] == 'processing') {
			$items = array_values($order->get_items());
			$customer = $order->get_customer_id();
			$product_id = $items[0]['product_id'];
			//wp_die(var_dump($product_id));
			$product_membership = get_post_meta($product_id, '_membership', true);

			$membership_methods	= new IMS_Membership_Method();
			$membership_methods->update_user_membership($customer, $product_membership, 'paypal');
		}
	}


}