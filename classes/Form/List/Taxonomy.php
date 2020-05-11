<?php
/**
 *  Show taxonomy listing.
 *
 * @package DynTaxMI
 * @subpackage Form
 * @since 20200507
 */
defined( 'ABSPATH' ) || exit;


class DynTaxMI_Form_List_Taxonomy extends DynTaxMI_Form_List_Base {


	public function __construct( array $args = array() ) {
		$list = array(
			'singular' => __( 'sub-menu',   'dyntaxmi' ),
			'plural'   => __( 'sub-menus', 'dyntaxmi' ),
		);
		$list = array_merge( $list, $args );
		parent::__construct( $list );
	}

	public function prepare_items() {
		$this->prepare_columns();
		$this->process_bulk_action();
		$this->items = array();
		$this->sort_items();
		$this->set_paging();
	}

	protected function sort_items() {
		if ( $this->items ) {
			usort(
				$this->items,
				function( $a, $b ) {
					return strcasecmp( $a['title'], $b['title'] );
				}
			);
		}
	}


	/**  Column functions  **/

	protected function prepare_columns() {
		$columns  = $this->get_columns();
		$hidden   = $this->get_hidden_columns();
		$sortable = $this->get_sortable_columns();
		$this->_column_headers = array( $columns, $hidden, $sortable );
	}


	public function get_columns() {
		return array(
			'cb'       => '<input type="checkbox" />',
			'title'    => __( 'Name', 'dyntaxmi' ),
			'active'   => __( 'Active', 'dyntaxmi' ),
			'type'     => __( 'Taxonomy', 'dyntaxmi' ),
			'menu'     => __( 'Menu', 'dyntaxmi' ),
			'position' => __( 'Position', 'dyntaxmi' ),
		);
	}

	/**
	 *  Columns to make sortable.
	 *
	 * @since 20200511
	 * @return array
	 */
	public function get_sortable_columns() {
		return array(
			'title' => array( 'title', false ),
			'menu'  => array( 'menu', false )
		);
	}

	public function column_default( $item, $column_name ) {
		switch( $column_name ) {
			case 'active':
				return ( $item[ $column_name ] ) ? __( 'Yes', 'dyntaxmi' ) : __( 'No', 'dyntaxmi' );
			case 'title':
			case 'type':
			case 'menu':
			case 'position':
				return $item[ $column_name ];
			default:
				return print_r( $item, true ) ; // Show the whole array for troubleshooting purposes
		}
	}


	/**  Bulk actions  **/

	/**
	 *  Render the bulk edit checkbox.
	 *
	 * @since 20200511
	 * @param array $item
	 * @return string
	 */
	function column_cb( $item ) {
		return sprintf(
			'<input type="checkbox" name="bulk-delete[]" value="%s" />', $item['title']
		);
	}

	/**
	 * Returns an associative array containing the bulk action.
	 *
	 * @since 20200511
	 * @return array
	 */
	public function get_bulk_actions() {
		return array(
			'bulk-delete' => 'Delete',
		);
	}

	/**
	 *  Process actions.
	 *
	 * @since 20200511
	 */
	public function process_bulk_action() {
		//  Check for nonce
		if ( ! array_key_exists( '_wpnonce', $_REQUEST ) ) {
			return;
		}
		//  Verify nonce.
		$nonce = esc_attr( $_REQUEST['_wpnonce'] );
		if ( ! wp_verify_nonce( $nonce, 'sp_delete_customer' ) ) {
			wp_die( __( 'Unable to process request.', 'dyntaxmi' ) );
		}
		//  Single delete requested.
		if ( 'delete' ===  $this->current_action() ) {
			# TODO: delete record here
			wp_redirect( esc_url( add_query_arg() ) );
			exit;
		}
		// Check for bulk action.
		if ( ( array_key_exists( 'action', $_POST ) && ( $_POST['action'] === 'bulk-delete' ) ) || ( array_key_exists( 'action2', $_POST ) && ( $_POST['action2'] === 'bulk-delete' ) ) ) {
			$deletes = esc_sql( $_POST['bulk-delete'] );
			foreach( $deletes as $title ) {
				# TODO: delete record here
			}
			wp_redirect( esc_url( add_query_arg() ) );
			exit;
		}
	}

}
