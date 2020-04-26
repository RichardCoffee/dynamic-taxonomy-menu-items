<?php
/**
 *  Provides plugin access to core trait functions.
 *
 * @package DynTaxMI
 * @subpackage Plugin
 * @since 20200425
 * @author Richard Coffee <richard.coffee@rtcenterprises.net>
 * @copyright Copyright (c) 2020, Richard Coffee
 */
defined( 'ABSPATH' ) || exit;

class DynTaxMI_Plugin_dtmiLib extends DynTaxMI_Plugin_Library {


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


}
