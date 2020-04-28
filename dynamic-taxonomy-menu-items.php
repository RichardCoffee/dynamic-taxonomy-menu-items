<?php
/**
 *  Dynamic Taxonomy Menu Items for WordPress
 *
 * @package   DynamicTaxonomy
 * @author    Richard Coffee <richard.coffee@rtcenterprises.net>
 * @copyright 2020 Richard Coffee
 * @license   GPLv3  <https://www.gnu.org/licenses/gpl-3.0.html>
 * @link      https://github.com/RichardCoffee/dynamic-taxonomy-menu-items
 *
 * @wordpress-plugin
 * Plugin Name:       Dynamic Taxonomy Menu Items
 * Plugin URI:        https://github.com/RichardCoffee/dynamic-taxonomy-menu-items
 * Description:       Inserts dynamic submenus of taxonomy items into WordPress menus.
 * Tags:              menu, taxonomy
 * Version:           1.0.2
 * Requires at least: 4.7.0
 * Tested up to:      5.4.0
 * Requires PHP:      5.3.6
 * Author:            Richard Coffee
 * Author URI:        https://rtcenterprises.net
 * Text Domain:       dyntaxmi
 * License:           GPL v3
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.html
 * Domain Path:       /languages
 */

defined( 'ABSPATH' ) || exit;

/*
 * @link https://github.com/helgatheviking/Nav-Menu-Roles/blob/master/nav-menu-roles.php
if ( ! defined('ABSPATH') || ! function_exists( 'is_admin' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}
*/

define( 'DYNTAXMI_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

require_once( 'functions.php' );

$dyntaxmi = DynTaxMI_Plugin_DynTaxMI::get_instance( array( 'file' => __FILE__ ) );

register_activation_hook( __FILE__, array( 'DynTaxMI_Register_Plugin', 'activate' ) );
