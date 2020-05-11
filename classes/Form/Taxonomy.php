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
	 * @since 20200511
	 * @var string  Link to add new sub-menu.
	 */
	protected $add_new = '';
	/**
	 * @since 20200505
	 * @var string  User capability required.
	 */
	protected $capability = 'manage_options';
	/**
	 * @since 20200505
	 * @var string  Value returned by function adding the menu option.
	 */
	protected $hook;
	/**
	 * @since 20200507
	 * @var DynTaxMI_Form_List_Taxonomy
	 */
	protected $listing;
	/**
	 * @since 20200511
	 * @var int  Taxonomies per page.
	 */
	protected $per_page = 5;


	/**
	 *  Constructor method.
	 *
	 * @since 20200505
	 */
	public function __construct() {
		add_filter( 'set-screen-option', [ $this, 'set_screen_option' ], 10, 3 );
		add_action( 'admin_menu', [ $this, 'add_menu_option' ] );
		$this->add_new = site_url();
	}

	/**
	 *  Activate the screen option.
	 *
	 * @since 20200511
	 * @param bool     $keep   Whether to save or skip saving the screen option value. Default false.
	 * @param string   $option The option name.
	 * @param int      $value  The number of rows to use.
	 */
	public function set_screen_option( $keep, $option, $value ) {
		return $value;
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
			$this->hook = add_theme_page( $text, $text, $this->capability, 'dtmi_listing', [ $this, 'listing' ] );
			add_action( "load-{$this->hook}", [ $this, 'add_screen_options' ] );
		}
	}

	/**
	 *  Add screen options.
	 *
	 * @since 20200511
	 */
	public function add_screen_options() {
		$opts = array(
			'label'   => __( 'Taxonomies per page', 'dyntaxmi' ),
			'default' => $this->per_page,
			'option'  => 'taxes_per_page'
		);
		add_screen_option( 'per_page', $opts );
		if ( ! class_exists( 'WP_List_Table' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
		}
		$args = array(
			'per_page' => $this->per_page,
		);
		$this->listing = new DynTaxMI_Form_List_Taxonomy( $args );
	}

	/**
	 *  Show the listing page
	 *
	 * @since 20200506
	 */
	public function listing() {
		dyntaxmi()->tag( 'div', [ 'class' => 'wrap' ] );
			dyntaxmi()->element( 'div', [ 'id' => 'icon-users', 'class' => 'icon32' ] );
			dyntaxmi()->element( 'h1', [ 'class' => 'wp-heading-inline' ], __( 'Dynamic Taxonomy Sub-Menus', 'dyntaxmi' ) );
			dyntaxmi()->element( 'a', [ 'class' => 'page-title-action', 'href' => $this->add_new ], __( 'Add New' ) );
			dyntaxmi()->tag( 'form', [ 'id' => 'posts-filter', 'method' => 'post' ] );
				$this->listing->prepare_items();
				$this->listing->display();
			echo '</form>';
		echo '</div>';
	}


}
