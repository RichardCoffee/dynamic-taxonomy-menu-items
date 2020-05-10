<?php
/**
 *  Plugin base class extending WP_List_Table
 *
 * @package DynTaxMI
 * @subpackage Form
 * @since 20200507
 * @link https://www.sitepoint.com/using-wp_list_table-to-create-wordpress-admin-tables/
 * @link https://premiumcoding.com/wordpress-tutorial-how-to-extend-wp-list-table/
 */
defined( 'ABSPATH' ) || exit;


class DynTaxMI_Form_BaseList extends WP_List_Table {


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
