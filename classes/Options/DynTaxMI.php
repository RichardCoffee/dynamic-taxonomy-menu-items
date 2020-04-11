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
	 * @since 20200410
	 * @var int  Maximum menu item count.
	 */
	private $max_count = 0;
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
			'position' => array(
				'default' => 1,
				'label'   => __( 'Position', 'dyntaxmi' ),
				'text'    => __( 'Position in the menu. Starts at 0.  You may need to experiment with this to make it show up where you want.', 'dyntaxmi' ),
				'render'  => 'spinner',
				'attrs'   => array(
					'min' => '0',
					'max' => "{$this->max_count}", // FIXME:  get a top level count. use js to match chosen menu.
				),
			),
			'maximum' => array(
				'default' => 6,
				'label'   => __( 'Maximum Items', 'dyntaxmi' ),
				'text'    => __( 'Set the maximum number of items to appear on the sub-menu.', 'dyntaxmi' ),
				'render'  => 'spinner',
				'attrs'   => array(
					'min' => '1',
					'max' => '12',  // FIXME:  get a tax count, use js to match chosen menu.
				),
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
			$this->max_count = max( $this->max_count, $object->count );
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
//		$count  = array();
		foreach( $taxes as $key => $object ) {
			$select[ $key ] = $object->label;
//			$count[  $key ] = $object->count;
		}
		return $select;
	}


}
