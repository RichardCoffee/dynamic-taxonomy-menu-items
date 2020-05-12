<?php
/**
 *  Plugin base class extending WP_List_Table
 *
 * @package DynTaxMI
 * @subpackage Form
 * @since 20200507
 * @link https://gist.github.com/paulund/7659452
 * @link https://www.sitepoint.com/using-wp_list_table-to-create-wordpress-admin-tables/
 * @link https://premiumcoding.com/wordpress-tutorial-how-to-extend-wp-list-table/
 * @link https://www.smashingmagazine.com/2011/11/native-admin-tables-wordpress/
 */
defined( 'ABSPATH' ) || exit;


class DynTaxMI_Form_List_Base extends WP_List_Table {


	/**
	 * @since 20200511
	 * @var int  Current page number.
	 */
	protected $current = 1;
	/**
	 * @since 20200511
	 * @var string  Slug for per page screen option.
	 */
	protected $per_option = 'items_per_page';
	/**
	 * @since 20200510
	 * @var int  Items per page.
	 */
	protected $per_page = 5;


	/**
	 * @since 20200507
	 * @link https://premiumcoding.com/wordpress-tutorial-how-to-extend-wp-list-table/
	 */
	use DynTaxMI_Trait_ParseArgs;

	/**
	 *  Constructor method
	 *
	 * @since 20200507
	 * @param array $args  Initialize class properties
	 */
	public function __construct( array $args = array() ) {
		$defaults = array(
			'singular' => __( 'Item', 'dyntaxmi' ),
			'plural'   => __( 'Items', 'dyntaxmi' ),
			'ajax'     => false,
			'screen'   => null,
		);
		$args = array_merge( $defaults, $args );
		$wplt = array_intersect_key( $args, $defaults );
		parent::__construct( $wplt );
		$safe = $this->pre_existing();
		$diff = array_diff_key( $args, $defaults, $safe );
		if ( $diff ) $this->parse_args( $diff );
		$this->screen_per_page();
	}

	/**
	 *  Replace default message for no items.
	 *
	 * @since 20200507
	 */
	public function no_items() {
		echo esc_html( sprintf( _x( 'No %s found', 'placeholder is plural', 'dyntaxmi' ), $this->_args['plural'] ) );
	}

	/**
	 *  Default value for visible columns.
	 *
	 * @since 20200509
	 * @return array
	 */
	public function get_columns() {
		return array(
			'title' => __( 'Title', 'dyntaxmi' ),
		);
	}

	/**
	 *  Default value for hidden columns.
	 *
	 * @since 20200509
	 * @return array
	 */
	public function get_hidden_columns() {
		return array();
	}

	/**
	 *  Default value for sortable columns.
	 *
	 * @since 20200509
	 * @return array
	 */
	public function get_sortable_columns() {
		return array();
	}

	/**
	 *  Set the screen per page option.
	 *
	 * @since 20200511
	 */
	protected function screen_per_page() {
		$opts = array(
			'label'   => sprintf( _x( '%s per page', 'placeholder is plural', 'dyntaxmi' ), mb_convert_case( $string, MB_CASE_TITLE ) ),
			'default' => $this->per_page,
			'option'  => $this->per_option,
		);
		add_screen_option( 'per_page', $opts );
	}

	/**
	 *  Set pagination parameters.
	 *
	 * @since 20200510
	 * @param array $args  Pagination data.
	 */
	protected function set_paging( array $args = array() ) {
		$default = array(
			'total_items' => count( $this->items ),
			'per_page'    => $this->per_page,
		);
		$args = array_merge( $default, $args );
		$args['total_pages'] = ceil( $args['total_items'] / $args['per_page'] );
		$this->set_pagination_args( $args );
	}

	/**
	 *  Add extra markup in the toolbars before or after the list.
	 *
	 * @since 20200511
	 * @param string $which  Add the markup after (bottom) or before (top) the list.
	 */
	protected function extra_tablenav( $which ) {
		if ( $which === "top" ) {
			if ( method_exists( $this, 'before_table' ) ) {
				$this->before_table();
			}
		}
		if ( $which === "bottom" ) {
			if ( method_exists( $this, 'after_table' ) ) {
				$this->after_table();
			}
		}
	}

	/**
	 *  Array of properties used in base class.
	 *
	 * @since 20200507
	 * @return array  Fields used in base class.
	 */
	private function pre_existing() {
		return array(
			'items'            => null,
			'_args'            => null,
			'_pagination_args' => null,
			'_actions'         => null,
			'_pagination'      => null,
			'modes'            => [],
			'_column_headers'  => null,
			'compat_fields'    => [],
			'compat_methods'   => [],
		);
	}


}
