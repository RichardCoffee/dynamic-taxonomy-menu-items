<?php
/**
 *  Add the terms of a taxonomy to a menu
 *
 * @package DynTaxMI
 * @subpackage Taxonomy
 * @since 20170111
 * @author Richard Coffee <richard.coffee@rtcenterprises.net>
 * @copyright Copyright (c) 2018, Richard Coffee
 * @link https://github.com/RichardCoffee/fluidity-theme/blob/master/classes/NavWalker/Taxonomy.php
 * @link https://gist.github.com/daggerhart/c17bdc51662be5a588c9
 */
defined( 'ABSPATH' ) || exit;

class DynTaxMI_NavWalker_Taxonomy extends DynTaxMI_NavWalker_Dynamic {

	/**
	 * @since 20180816
	 * @var string  Default order that terms are retrieved in.
	 */
	protected $order = 'DESC';
	/**
	 * @since 20180816
	 * @var string  Default field used to order terms.
	 */
	protected $orderby = 'count';
	/**
	 * @since 20180816
	 * @var int  Default parent id.
	 */
	protected $parent =  0;
	/**
	 * @since 20180816
	 * @var string  Taxonomy requested - Also used used as css postfix, and for filters.
	 * @see DynTaxMI_NavWalker_Dynamic::$type
	 */
	protected $type = 'category';

	/**
	 *  constructor function.
	 *
	 * @since 20180905
	 * @param array $args Only valid indexes are existing class properties.
	 */
	public function __construct( $args = array() ) {
		parent::__construct( $args );
		$terms = $this->get_terms();
		if ( is_wp_error( $terms ) ) {
			dyntaxmi(1)->log( $terms );
		} else {
			$this->menu     = apply_filters( "dyntaxmi_{$this->type}_menu",     $this->menu );
			$this->position = apply_filters( "dyntaxmi_{$this->type}_position", $this->position, $this->menu );
			$this->add_terms( $terms );
		}
	}

	/**
	 *  get the taxonomy terms
	 *
	 * @since 20180916
	 * @link https://developer.wordpress.org/reference/functions/get_terms/
	 * @return array
	 */
	public function get_terms() {
		$args = array(
			'taxonomy'        => $this->type,
			'hide_empty'      => true,
			'order'           => $this->order,
			'orderby'         => $this->orderby,
			'parent'          => $this->parent, // 0 = show only top-level terms
			'suppress_filter' => false,
		);
		return get_terms( $args );
	}

	/**
	 *  add taxonomy name to top level menu, and taxonomy terms as submenu
	 *
	 * @since 20180916
	 * @param array $terms
	 * @uses DynTacMI_Trait_Attributes::get_element()
	 */
	public function add_terms( $terms ) {
		$tax_meta = get_taxonomy( $this->type );
		if ( $tax_meta ) {
			$title   = ( empty( $this->title ) ) ? $tax_meta->labels->name : $this->title;
			$pattern = '%1$s' . dyntaxmi()->get_element( 'span', [ 'class' => [ 'term-count', "{$this->type}-term-count" ] ], '%2$s' );
			$pattern = apply_filters( "dyntaxmi_{$this->type}_format", $pattern, $terms );
			$order   = 1;
			$this->add_menu_item( $title );
			foreach( $terms as $term ) {
				if ( ! ( $this->limit < $term->count ) ) { break; }
				if ( $order > $this->maximum ) { break; }
				$name = sprintf( $pattern, $term->name, $term->count );
				$link = get_term_link( $term );
				$this->width = max( $this->width, ( strlen( $term->name . $term->count ) + 3 ) );
				$this->add_sub_menu_item( $name, $link, $order++, $this->type );
			}
		}
	}


}
