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
				'divcss'  => 'dyntaxmi-type',
				'showhide' => array(
					'origin' => 'dyntaxmi-type',
					'target' => 'dyntaxmi-exclude',
					'show'   => 'category',
				)
			),
			'title' => array(
				'default' => __( 'Articles', 'dyntaxmi' ),
				'label'   => __( 'Sub-Menu Title', 'dyntaxmi' ),
				'place'   => __( 'Sub-Menu Title', 'dyntaxmi' ),
				'text'    => __( 'This will be the text, for the taxonomy, that appears on the menu.', 'dyntaxmi' ),
				'render'  => 'text',
			),
			'position' => array(
				'default' => 1,
				'label'   => __( 'Position', 'dyntaxmi' ),
				'text'    => __( 'Position in the menu. Starts at 0.  You may need to experiment with this to make it show up where you want.', 'dyntaxmi' ),
				'render'  => 'spinner',
				'attrs'   => array(
					'min' => '0',
					'max' => "{$this->max_count}", // TODO:  get a top level count. use js to match chosen menu.
				),
			),
			'maximum' => array(
				'default' => 6,
				'label'   => __( 'Maximum Items', 'dyntaxmi' ),
				'text'    => __( 'Set the maximum number of items to appear on the sub-menu.', 'dyntaxmi' ),
				'render'  => 'spinner',
				'attrs'   => array(
					'min' => '1',
					'max' => '12',  // TODO:  get a tax count, use js to match chosen menu.
				),
			),
			'exclude' => array(
				'default' => [ 1 ],
				'label'   => __( 'Exclude Terms', 'dyntaxmi' ),
				'text'    => __( 'You can exclude category terms using this pull-down.', 'dyntaxmi' ),
				'help'    => __( "Utilize the 'ctrl+click' combo to choose exclude terms.", 'dyntaxmi' ),
				'render'  => 'select_multiple',
				'source'  => $this->get_terms(), // TODO:  get terms from all taxes, use js to match chosen taxonomy.
				'divcss'  => 'dyntaxmi-exclude',
			),
			'count' => array(
				'default' => true,
				'label'   => __( 'Show Count', 'dyntaxmi' ),
				'text'    => __( 'Show the post count on sub-menu items.', 'dyntaxmi' ),
				'render'  => 'checkbox',
			),
			'limit' => array(
				'default' => 0,
				'label'   => __( 'Count Limit', 'dyntaxmi' ),
				'text'    => __( 'Set this if you wish to filter the sub-menu items by post count.', 'dyntaxmi' ),
				'render'  => 'spinner',
				'attrs'   => [ 'min' => '0' ],
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
		foreach( $menus as $key => $object ) {
			$this->max_count = max( $this->max_count, $object->count );
		}
		return wp_list_pluck( $menus, 'name', 'slug' );
	}

	/**
	 *  Returns an array of taxonomies suitable for use with select.
	 *
	 * @since 20200409
	 * @return array
	 */
	private function get_taxonomies() {
		$taxes = get_taxonomies( [ 'public' => true ], 'name' );
		return wp_list_pluck( $taxes, 'label', 'name' );
	}

	/**
	 *  Returns an array of taxonomy terms suitable for use with select.
	 *
	 * @since 20200414
	 * @return array
	 */
	private function get_terms() {
		$args = array(
			'taxonomy' => 'category',
			'order'    => 'ASC',
			'orderby'  => 'name',
		);
		$terms = get_terms( $args );
		return wp_list_pluck( $terms, 'name', 'slug' );
	}


}
