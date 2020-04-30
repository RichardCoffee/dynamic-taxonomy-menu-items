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
	 * @since 20200424
	 * @var string  Prefix for database option name field.
	 */
#	protected $prefix = 'dyntaxmi';
	/**
	 * @since 20200408
	 * @var string  Form slug.
	 */
	protected $slug = 'dyntaxmi';
	/**
	 * @since 20200424
	 * @var string  Form type.
	 */
	protected $type = 'tabbed';


	/**
	 *  Constructor method.
	 *
	 * @since 20200408
	 */
	public function __construct() {
		$this->tab = $this->slug;
		add_action( 'admin_menu',              [ $this, 'add_menu_option' ] );
		add_filter( "form_text_{$this->slug}", [ $this, 'form_text_filter' ],   10, 2 );
		parent::__construct();
	}

	/**
	 *  Add the form to the Appearence menu.
	 *
	 * @since 20200408
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
	 *  Enqueue required script and style files.
	 *
	 * @since 20200414
	 * @param string $hook  Suffix for action hook - not used here.
	 */
	public function admin_enqueue_scripts( $hook ) {
		$paths = DynTaxMI_Plugin_Paths::instance();
		wp_enqueue_style(  'dyntaxmi-form.css', $paths->get_plugin_file_uri( 'css/admin-form.css' ), null, $paths->version );
		wp_enqueue_script( 'dyntaxmi-form.js',  $paths->get_plugin_file_uri( 'js/admin-form.js' ), array( 'jquery' ), $paths->version, true );
		$this->add_localization_object( 'dyntaxmi-form.js' );
	}

	/**
	 *  Initialize the form options.
	 *
	 * @since 20200425
	 */
	public function initialize_options() {
		new DynTaxMI_Options_DynTaxMI();
		new DynTaxMI_Options_Forums();
	}

	/**
	 *  Get the options layout.
	 *
	 * @since 20200408
	 * @param  string $section  Passed if tabbed layout, layout section to return.
	 * @return array            Form layout, entire form or requested section.
	 */
	protected function form_layout( $section = '' ) {
		$this->initialize_options();
		$form['title'] = __( 'Dynamic Taxonomy Menu Items', 'dyntaxmi' );
		$form = apply_filters( 'fluidity_options_form_layout', $form );
		return ( empty( $section ) ) ? $form : $form[ $section ];
	}

	/**
	 *  Filter the standard form text.
	 *
	 * @since 20200412
	 * @param  array $text  The form text.
	 * @return array        The filtered text.
	 */
	public function form_text_filter( $text ) {
		$text['submit']['object']  = __( 'Dynamic', 'dyntaxmi' );
		$text['submit']['subject'] = __( 'Dynamic', 'dyntaxmi' );
		return $text;
	}

	/**
	 *
	 *
	 * @since 20200430
	 */
	protected function get_form_options() {
		parent::get_form_options();
		if ( ! array_key_exists( 'ordering', $this->form_opts ) ) {
$this->log(
"current: {$this->current}",
"   slug: {$this->slug}",
$this->form_opts
);
		}
	}


}
