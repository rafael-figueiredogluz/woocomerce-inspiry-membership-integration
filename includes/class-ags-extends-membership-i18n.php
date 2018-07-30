<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       www.agenciadosite.com.br
 * @since      1.0.0
 *
 * @package    Ags_Extends_Membership
 * @subpackage Ags_Extends_Membership/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Ags_Extends_Membership
 * @subpackage Ags_Extends_Membership/includes
 * @author     Rafael Figueiredo <suporte@agenciadosite.com.br>
 */
class Ags_Extends_Membership_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'ags-extends-membership',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
