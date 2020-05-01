<?php
/**
 *  Main plugin class file.
 *
 * @package DynTaxMI
 * @subpackage Core
 * @since 20170111
 * @author Richard Coffee <richard.coffee@rtcenterprises.net>
 * @copyright Copyright (c) 2017, Richard Coffee
 * @link https://github.com/RichardCoffee/custom-post-type/blob/master/classes/Plugin/Base.php
 */
defined( 'ABSPATH' ) || exit;
/**
 *  Dynamic Taxonomy Menu Items.
 *
 * @since 20180404
 * @link https://github.com/RichardCoffee/dynamic-taxonomy-menu-items/blob/master/classes/Plugin/DynTaxMI.php
 */
class DynTaxMI_Plugin_DynTaxMI extends DynTaxMI_Plugin_Plugin {


	/**
	 *
	 * @since 20200410
	 * @var string  Path to plugin options page, used on the WP Dashboard Plugins page
	 * @todo:  Is there a way to derive this value instead of having to set it manually?
	 */
	protected $setting = 'themes.php?page=dyntaxmi';


	/**
	 * @since 20200201
	 * @link https://github.com/RichardCoffee/custom-post-type/blob/master/classes/Trait/Singleton.php
	 */
	use DynTaxMI_Trait_Singleton;


	/**
	 *  Initialize the plugin.
	 *
	 * @since 20180404
	 */
	public function initialize() {
		if ( ( ! DynTaxMI_Register_Plugin::php_version_check() ) || ( ! DynTaxMI_Register_Plugin::wp_version_check() ) ) {
			return;
		}
		register_deactivation_hook( $this->paths->file, [ 'DynTaxMI_Register_Plugin', 'deactivate' ] );
		register_uninstall_hook(    $this->paths->file, [ 'DynTaxMI_Register_Plugin', 'uninstall'  ] );
		$this->add_actions();
		$this->add_filters();
		if ( is_admin() ) {
			new DynTaxMI_Form_DynTaxMI();
		}
	}

	/**
	 *  Establish actions.
	 *
	 * @since 20180404
	 */
	public function add_actions() {
		add_action( 'wp_head',            [ $this, 'wp_head' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'wp_enqueue_scripts' ] );
		parent::add_actions();
	}

	/**
	 *  Establish filters.
	 *
	 * @since 20180404
	 */
	public function add_filters() {
		parent::add_filters();
	}

	/**
	 *  Run during 'wp_head' action.
	 *
	 * @since 20200407
	 */
	public function wp_head() {
		$this->add_taxonomy();
		if ( is_callable( 'bbpress' ) ) {
			$this->add_forums();
		}
		$this->add_custom_css();
	}

	/**
	 *  Add a taxonomy to the menu.
	 *
	 * @since 20200406
	 */
	protected function add_taxonomy() {
		$options  = $this->get_option( 'dyntaxmi' );
		$options  = $this->ordering_check( $taxonomy );
		$defaults = $this->get_taxonomy_defaults();
		$taxonomy = array_merge( $defaults, $options );
		if ( $taxonomy['active'] ) {
			// TODO:  allow excludes for all taxonomies, will require javascript solution.
			if ( ! in_array( $taxonomy['type'], [ 'category' ] ) ) {
				$taxonomy['exclude'] = [];
			}
			dyntaxmi_tax( $taxonomy );
		}
	}

	/**
	 *  Provides taxonomy default values.
	 *
	 * @since 20200411
	 * @return array
	 */
	protected function get_taxonomy_defaults() {
		return array(
			'active'     => false,
			'css_action' => 'dyntaxmi_custom_css',
			'count'      => true,
			'exclude'    => [],
			'limit'      => 0,
			'maximum'    => 7,
			'menu'       => 'primary-menu',
#			'order'      => 'desc',
#			'orderby'    => 'count',
			'ordering'   => 'count-desc',
			'position'   => 1,
			'title'      => __( 'Articles', 'dyntaxmi' ),
			'type'       => 'category',
		);
	}

	protected function ordering_check( $opts ) {
		//  Exists in version 1.1.0 and above
		if ( array_key_exists( 'ordering', $opts ) ) {
			list( $opts['orderby'], $opts['order'] ) = explode( '-', $opts['ordering'] );
			$opts['orderby'] = ( $opts['orderby'] === 'term' ) ? 'term_taxonomy_id' : $opts['orderby'];
		}
		return $opts;
	}

	/**
	 *  Add bbpress forums to a menu.
	 *
	 * @since 20200424
	 */
	protected function add_forums() {
		$options  = $this->get_option( 'bbpress', array() );
		$defaults = $this->get_bbpress_defaults();
		$forums   = array_merge( $defaults, $options );
		if ( $forums['active'] ) {
			dyntaxmi_forums( $forums );
		}
	}

	/**
	 *  Provides bbpress forums defaults.
	 *
	 * @since 20200424
	 * @return array  Defaults for bbpress forums.
	 */
	protected function get_bbpress_defaults() {
		return array(
			'active'   => false,
			'menu'     => 'primary-menu',
			'position' => 2,
			'title'    => __( 'Forums', 'dyntaxmi' ),
		);
	}

	/**
	 *  Add custom css for taxonomy menu items.
	 *
	 * @since 20200407
	 */
	protected function add_custom_css() {
		ob_start();
		do_action( 'dyntaxmi_custom_css' );
		$css = ob_get_clean();
		if ( $css ) {
			$attrs = array(
				'id'   => 'dyntaxmi-custom-css',
				'type' => 'text/css',
			);
			dyntaxmi()->element( 'style', $attrs, $css, true );
		}
	}

	/**
	 *  Load style sheet.
	 *
	 * @since 20200407
	 */
	public function wp_enqueue_scripts() {
		wp_enqueue_style( 'dyntaxmi-css', $this->paths->get_plugin_file_uri( 'css/dyntaxmi.css' ), null, $this->paths->version );
	}

	/**
	 *  Get options for a submenu.
	 *
	 * @since 20200424
	 */
	protected function get_option( $slug ) {
		if ( in_array( $slug, [ 'bbpress', 'dyntaxmi' ] ) ) {
			$option = get_option( "tcc_options_$slug", array() );
			if ( $option ) return $option;
		}
		$option = get_option( "dyntaxmi_$slug", array() );
		return $option;
	}


}
