<?php
/**
 *  Plugin options.
 *
 * @since 20200408
 */
defined('ABSPATH') || exit;


class DynTaxMI_Options_DynTaxMI extends DynTaxMI_Options_Options {


	/**
	 * @since 20200408
	 * @var string
	 */
	protected $base = 'dyntaxmi';
	/**
	 * @since 20200408
	 * @var int
	 */
	protected $priority = 800;


	/**
	 *  Returns the form title.
	 *
	 * @since 20200408
	 * @return string
	 */
	protected function form_title() {
		return __( 'Dynamic Taxonomy Menu Items', 'dyntaxmi' );
	}

	/**
	 *  Returns the CSS for the dashicon for a tabbed screen.
	 *
	 * @since 20200408
	 * @return string
	 */
	protected function form_icon() {
		return 'dashicons-list-view';
	}

	/**
	 *  Displays description text.
	 *
	 * @since 20200408
	 */
	public function describe_options() {
		esc_html_e( 'These options control the settings for the chosen taxonomy.', 'dyntaxmi' );
	}

	/**
	 *  Returns the layout for the settings screen.
	 *
	 * @since 20200409
	 * @return array
	 */
	protected function options_layout() {
		return array(
			'menu' => array(
				'default' => 'primary-menu',
				'label'   => __( 'Menu', 'dyntaxmi' ),
				'text'    => __( 'Choose the menu', 'dyntaxmi' ),
				'render'  => 'select',
				'source'  => $this->get_menus(),
			),
			'type' => array(
				'default' => 'category',
				'label'   => __( 'Taxonomy', 'dyntaxmi' ),
				'text'    => __( 'Choose the taxonomy', 'dyntaxmi' ),
				'render'  => 'select',
				'source'  => $this->get_taxonomies(),
			),
		);
	}

	/**
	 *  Return an array of menus suitable for use with select.
	 *
	 * @since 20200410
	 * @return array
	 */
	private function get_menus() {
		$menus = wp_get_nav_menus( [ 'hide_empty' => true ] );
		$select = array();
		foreach( $menus as $key => $object ) {
			$select[ $object->slug ] = $object->name;
		}
		return $select;
	}

	/**
	 *  Returns an array of taxonomies suitable for use with select.
	 *
	 * @since 20200409
	 * @return array
	 */
	private function get_taxonomies() {
		$taxes  = get_taxonomies( [ 'public' => true ], 'name' );
		$select = array();
		foreach( $taxes as $key => $object ) {
			$select[ $key ] = $object->label;
		}
		return $select;
	}


}
