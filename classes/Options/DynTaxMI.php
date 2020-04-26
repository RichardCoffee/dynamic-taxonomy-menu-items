<?php
/**
 *  Plugin options.
 *
 * @since 20200408
 */
defined( 'ABSPATH' ) || exit;


class DynTaxMI_Options_DynTaxMI extends DynTaxMI_Options_Options {


	/**
	 * @since 20200408
	 * @var string
	 */
	protected $base = 'dyntaxmi';
	/**
	 * @since 20200408
	 * @var int  Controls order on tabbed screen.
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
	 * @return array  Form layout.
	 */
	protected function options_layout() {
		return array(
			'active' => array(
				'default' => 0,
				'label'   => __( 'Usage', 'dyntaxmi' ),
				'text'    => __( 'Check here to activate the taxonomy submenu.', 'dyntaxmi' ),
				'render'  => 'checkbox',
			),
			'menu' => array(
				'default' => 'primary-menu',
				'label'   => __( 'Menu', 'dyntaxmi' ),
				'text'    => __( 'Choose the menu to add the sub-menu to, default is the Primary Menu.', 'dyntaxmi' ),
				'render'  => 'select',
				'source'  => dyntaxmi()->get_menus(),
			),
			'type' => array(
				'default' => 'category',
				'label'   => __( 'Taxonomy', 'dyntaxmi' ),
				'text'    => __( 'Choose the taxonomy to use, default is Categories.', 'dyntaxmi' ),
				'render'  => 'select',
				'source'  => $this->get_taxonomies(),
				'divcss'  => 'dyntaxmi-type',
				'showhide' => array(
					'origin' => 'dyntaxmi-type',
					'target' => 'dyntaxmi-exclude',
					'show'   => 'category',
				),
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
				'text'    => __( 'Position in the menu. Starts at 0, defaults to 1.', 'dyntaxmi' ),
				'help'    => __( 'You may need to experiment with this number to get the sub-menu show up where you want it to.', 'dyntaxmi' ),
				'render'  => 'spinner',
				'attrs'   => array(
					'min' => '0',
					'max' => dyntaxmi()->max_count, // TODO:  get a top level count. use js to match chosen menu.
				),
			),
			'orderby' => array(
				'default' => 'count',
				'label'   => __( 'Order By', 'dyntaxmi' ),
				'text'    => __( 'Control the order in which the sub-menu items are displayed.', 'dyntaxmi' ),
				'render'  => 'radio',
				'source'  => array(
					'count' => __( 'Post Count (default)', 'dyntaxmi' ),
					'name'  => __( 'Term Name', 'dyntaxmi' ),
					'term_taxonomy_id' => __( 'Term ID, although why?', 'dyntaxmi' ),
				),
			),
			'order' => array(
				'default' => 'desc',
				'label'   => 'Order Direction',
				'render'  => 'radio',
				'source'  => array(
					'desc' => __( 'Descending order, recommended for Post Count order. (default)', 'dyntaxmi' ),
					'asc'  => __( 'Ascending order,  recommended for Term Name order.', 'dyntaxmi' ),
				),
			),
			'maximum' => array(
				'default' => 7,
				'label'   => __( 'Maximum Items', 'dyntaxmi' ),
				'text'    => __( 'Set the maximum number of items to appear on the sub-menu, default is 7.', 'dyntaxmi' ),
				'help'    => __( 'Maximum value for this field is 12.  This is an arbitary value, and does not reflect on your website.', '' ),
				'render'  => 'spinner',
				'attrs'   => array(
					'min' => '1',
					'max' => '12',  // TODO:  get a tax count, use js to match chosen menu.
				),
			),
			'exclude' => array(
				'default' => [],
				'label'   => __( 'Exclude Terms', 'dyntaxmi' ),
				'text'    => __( 'You can exclude category terms using this list.', 'dyntaxmi' ),
				'help'    => __( "Utilize the 'ctrl+click' combo to choose multiple exclude terms.", 'dyntaxmi' ),
				'render'  => 'select_multiple',
				'source'  => $this->get_terms(), // TODO:  get terms from all taxes, use js to match chosen taxonomy.
				'divcss'  => 'dyntaxmi-exclude',
			),
			'count' => array(
				'default' => true,
				'label'   => __( 'Show Count', 'dyntaxmi' ),
				'text'    => __( 'Show the post count on sub-menu items, default is yes.', 'dyntaxmi' ),
				'render'  => 'checkbox',
			),
			'limit' => array(
				'default' => 0,
				'label'   => __( 'Count Limit', 'dyntaxmi' ),
				'text'    => __( 'Set this if you wish to filter the sub-menu items by post count, default is 0, which does not impose any limits.', 'dyntaxmi' ),
				'render'  => 'spinner',
				'attrs'   => [ 'min' => '0' ],
			),
		);
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
		return wp_list_pluck( $terms, 'name', 'term_id' );
	}


}
