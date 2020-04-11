<?php
/**
 *  Display the plugin options screen.
 *
 * @package DynTaxMI
 * @subpackage Forms
 * @since 20200408
 * @author Richard Coffee <richard.coffee@rtcenterprises.net>
 * @copyright Copyright (c) 2020, Richard Coffee
 * @link https://github.com/RichardCoffee/dynamic-taxonomy-menu-items/blob/master/classes/Form/DynTaxMI.php
 */
defined( 'ABSPATH' ) || exit;

class DynTaxMI_Form_DynTaxMI extends DynTaxMI_Form_Admin {


	/**
	 * @since 20170310
	 * @var string  Form slug.
	 */
	protected $slug = 'dyntaxmi';


	/**
	 *  Constructor method.
	 *
	 * @since 20170222
	 */
	public function __construct() {
		$this->tab = $this->slug;
		add_action( 'admin_menu',              [ $this, 'add_menu_option'    ] );
#		add_action( 'admin_enqueue_scripts',   [ $this, 'enqueue_theme_scripts' ] );
#		add_filter( "form_text_{$this->slug}", [ $this, 'form_text_filter' ], 10, 2 );
		parent::__construct();
	}

	/**
	 *  Add the form to the Appearence menu.
	 *
	 * @since 20170222
	 */
	public function add_menu_option() {
		$cap = 'activate_plugins';
		if ( current_user_can( $cap ) ) {
			$page = __( 'Dynamic Taxonomy', 'dyntaxmi' );
			$menu = __( 'Dynamic Taxonomy', 'dyntaxmi' );
			$func = array( $this, $this->render );
			$this->hook_suffix = add_theme_page( $page, $menu, $cap, $this->slug, $func );
		}
	}

	/**
	 *  Get the privacy options layout
	 *
	 * @since 20170222
	 * @param  array $form  Passed if tabbed layout
	 * @return array        Form layout
	 */
	protected function form_layout( $form = array() ) {
		$options = new DynTaxMI_Options_DynTaxMI;
		$form    = $options->default_form_layout();
		$form['title'] = __( 'Dynamic Taxonomy Menu Items', 'dyntaxmi' );
		return $form;
	}


}
