<?php
/**
 *  Show taxonomy listing.
 *
 * @package DynTaxMI
 * @subpackage Form
 * @since 20200507
 */
defined( 'ABSPATH' ) || exit;


class DynTaxMI_Form_Listing extends DynTaxMI_Form_BaseList {


	public function __construct( array $args = array() ) {
		$list = array(
			'singular' => __( 'Taxonomy',   'dyntaxmi' ),
			'plural'   => __( 'Taxonomies', 'dyntaxmi' ),
		);
		$list = array_merge( $list, $args );
		parent::__construct( $list );
	}

	public function get_columns() {
		return array(
			'title'    => __( 'Name', 'dyntaxmi' ),
			'active'   => __( 'Active', 'dyntaxmi' ),
			'type'     => __( 'Taxonomy', 'dyntaxmi' ),
			'menu'     => __( 'Menu', 'dyntaxmi' ),
			'position' => __( 'Position', 'dyntaxmi' ),
		);
	}

	public function prepare_items() {
#		$this->items = array();
	}



}
