<?php
/**
 *  Show listing for dynamic menu items.
 *
 * @package DynTaxMI
 * @subpackage Form
 * @since 20200505
 * @author Richard Coffee <richard.coffee@rtcenterprises.net>
 * @copyright Copyright (c) 2020, Richard Coffee
 * @link https://github.com/RichardCoffee/dynamic-taxonomy-menu-items/blob/master/classes/Form/Taxonomy.php
 */
defined( 'ABSPATH' ) || exit;


class DynTaxMI_Form_Taxonomy {


	/**
	 * @since 20200505
	 * @var string  User capability required.
	 */
	protected $capability = 'manage_options';
	/**
	 * @since 20200505
	 * @var string  Value returned by function adding the menu option.
	 */
	protected $hook_suffix;
	/**
	 * @since 20200507
	 * @var DynTaxMI_Form_BaseList
	 */
	protected $listing;


	/**
	 *  Constructor method.
	 *
	 * @since 20200505
	 */
	public function __construct() {
		add_action( 'admin_menu', [ $this, 'add_menu_option' ] );
	}

	/**
	 *  Add the menu option.
	 *
	 * @since 20200505
	 */
	public function add_menu_option() {
		if ( current_user_can( $this->capability ) ) {
			$text = __( 'Dynamic Menu', 'dyntaxmi' );
			$menu = __( 'Dynamic Menu', 'dyntaxmi' );
			$this->hook_suffix = add_theme_page( $text, $text, $this->capability, 'dtmi_listing', [ $this, 'listing' ] );
		}
	}

	/**
	 *  Show the listing page
	 *
	 * @since 20200506
	 */
	public function listing() {
		$args = array(
			'label'   => __( 'Taxonomies per page', 'dyntaxmi' ),
			'default' => 5,
			'option'  => 'taxes_per_page'
		);
		add_screen_option( 'per_page', $args );
		if ( ! class_exists( 'WP_List_Table' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
		}
		$this->listing = new DynTaxMI_Form_Listing();
	}


}
