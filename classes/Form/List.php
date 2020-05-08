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
		
	}

	public function prepare_items() {
		
	}



}
