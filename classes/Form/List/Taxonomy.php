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


	/**
	 * @since 20200511
	 * @var array  Available menus.
	 */
	protected $menus = array();
	/**
	 * @since 20200511
	 * @var DynTaxMI_Options_DynTaxMI
	 */
	protected $options;


	public function __construct( array $args = array() ) {
		$list = array(
			'singular' => __( 'sub-menu',   'dyntaxmi' ),
			'plural'   => __( 'sub-menus', 'dyntaxmi' ),
		);
		$list = array_merge( $list, $args );
		parent::__construct( $list );
		$this->menus   = dyntaxmi()->get_menus();
		$this->options = new DynTaxMI_Options_DynTaxMI();
	}

	public function prepare_items() {
		$this->prepare_columns();
		$this->process_bulk_action();
		$this->get_items();
		$this->sort_items();
		$this->set_paging();
	}

	/**
	 *  Retrieve the sub-menu list.
	 *
	 * @since 20200511
	 * @return array
	 */
	protected function get_items() {
		$menus = get_option( 'dyntaxmi_menus', array() );
		if ( $menus ) {
			$defs = $this->options->get_default_options();
			foreach( $menus as $key => $item ) {
				$menus[ $key ] = array_merge( $defs, $item );
			}
		}
		$this->items = $menus;
	}

	protected function sort_items() {
		if ( $this->items ) {
			// If no sort, default to title
			$orderby = ( array_key_exists( 'orderby', $_GET ) ) ? sanitize_key( $_GET['orderby'] ) : 'title';
			// If no order, default to asc
			$order = ( array_key_exists( 'order', $_GET ) ) ? sanitize_key( $_GET['order'] ) : 'asc';
			if ( array_key_exists( $orderby, $this->items ) ) {
				usort(
					$this->items,
					function( $a, $b ) use ( $orderby, $order ) {
						$cmp = strcasecmp( $a[ $orderby ], $b[ $order ] );
						return ( $order === 'asc' ) ? $cmp : -$cmp;
					}
				);
			}
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
		$options = $this->options->options_layout();
		return array(
			'cb'       => '<input type="checkbox" />',
			'title'    => $options['title']['label'],
			'active'   => $options['active']['label'],
			'type'     => $options['type']['label'],
			'menu'     => $options['menu']['label'],
			'position' => $options['position']['label'],
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
				return ( $item['active'] ) ? __( 'Yes', 'dyntaxmi' ) : __( 'No', 'dyntaxmi' );
			case 'menu':
				return $this->menus[ $items['menu'] ];
			case 'position':
			case 'title':
			case 'type':
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
