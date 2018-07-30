<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              www.agenciadosite.com.br
 * @since             1.0.0
 * @package           Ags_Extends_Membership
 *
 * @wordpress-plugin
 * Plugin Name:       Agência do Site - Extends Membership
 * Plugin URI:        www.agenciadosite.com.br
 * Description:       Plugin que adiciona a função de compra dos planos através do woocommerce.
 * Version:           1.0.0
 * Author:            Rafael Figueiredo
 * Author URI:        www.agenciadosite.com.br
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ags-extends-membership
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PLUGIN_NAME_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-ags-extends-membership-activator.php
 */
function activate_ags_extends_membership() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ags-extends-membership-activator.php';
	Ags_Extends_Membership_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-ags-extends-membership-deactivator.php
 */
function deactivate_ags_extends_membership() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ags-extends-membership-deactivator.php';
	Ags_Extends_Membership_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_ags_extends_membership' );
register_deactivation_hook( __FILE__, 'deactivate_ags_extends_membership' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-ags-extends-membership.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_ags_extends_membership() {

	$plugin = new Ags_Extends_Membership();
	$plugin->run();

}
run_ags_extends_membership();
