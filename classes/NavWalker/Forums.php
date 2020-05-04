<?php
/**
 *  Add bbPress forums as a dynamic sub-menu to a wordpress menu
 *
 * @package DynTaxMI
 * @subpackage bbPress
 * @since 20180905
 * @author Richard Coffee <richard.coffee@rtcenterprises.net>
 * @copyright Copyright (c) 2018, Richard Coffee
 * @link https://github.com/RichardCoffee/dynamic-taxonomy-menu-items/blob/master/classes/NavWalker/Forums.php
 * @link https://github.com/RichardCoffee/fluidity-theme/blob/master/classes/NavWalker/Forums.php
 */
defined( 'ABSPATH' ) || exit;


class DynTaxMI_NavWalker_Forums extends DynTaxMI_NavWalker_Dynamic {

	/**
	 * @since 20200502
	 * @var string  Default order that terms are retrieved in.
	 */
	protected $order = 'DESC';
	/**
	 * @since 20200502
	 * @var string  Default field used to order terms.
	 */
	protected $orderby = 'topic_count';
	/**
	 *  string used as postfix for css selector.
	 *
	 * @since 20180905
	 * @var string
	 * @see DynTaxMI_NavWalker_Dynamic::$type
	 */
	protected $type = 'forum';

	/**
	 *  constructor function.
	 *
	 * @since 20180905
	 * @param array $args Optional.  Associative array, whose only valid indexes are
	 *                    existing class properties, with additional class properties
	 *                    found in DynTaxMI_NavWalker_Dynamic. All other indexes will be ignored.
	 * @see DynTaxMI_NavWalker_Dynamic::__constructer()
	 * @uses home_url()
	 */
	public function __construct( $args = array() ) {
		if ( ! is_callable( 'bbpress' ) ) return;
		parent::__construct( $args );
		$this->link .= $this->bbp_get_form_option( '_bbp_root_slug', 'forum', true );
		$forums = $this->get_forums();
		if ( $forums ) {
			$this->get_forum_counts( $forums );
			$this->add_forums( $forums );
			$this->check_queried_object();
		}
	}

	/**
	 *  get all public forums.
	 *
	 * @since 20180905
	 * @uses get_posts()
	 * @return array
	 */
	protected function get_forums() {
		$args = array(
			'numberposts'         => -1,
			'post_type'           => bbp_get_forum_post_type(),
			'post_status'         => bbp_get_public_status_id(),
			'ignore_sticky_posts' => true,
			'hide_empty'          => false,
		);
		return get_posts( $args );
	}

	/**
	 *  get topic counts for forums.
	 *
	 * @since 20180905
	 * @param array $forums An array of WP_Post objects.
	 * @uses bbp_get_forum_topic_count()
	 * @return array Array of WP_Post objects with a topic_count property added.
	 */
	protected function get_forum_counts( &$forums ) {
		foreach( $forums as &$forum ) {
			$forum->topic_count = bbp_get_forum_topic_count( $forum->ID );
		}
		return $forums;
	}

	/**
	 *  add forums as main menu item.
	 *
	 * @since 20180906
	 * @param array $forums
	 * @uses DynTaxMI_Trait_Attributes::get_element()
	 * @uses bbp_get_forum_permalink()
	 */
	protected function add_forums( $forums ) {
		$title   = ( empty( $this->title ) ) ? $this->get_forums_title() : $this->title;
		$pattern = '%1$s ' . dyntaxmi()->get_element( 'span', [ 'class' => [ 'term-count', "{$this->type}-term-count" ] ], '%2$s' );
		$pattern = apply_filters( "dyntaxmi_{$this->type}_format", $pattern, $forums );
		$order   = 1;
		$this->add_menu_item( $title );
		usort( $forums, [ $this, 'sort_forums' ] );
		foreach( $forums as $forum ) {
			$name = sprintf( $pattern, $forum->post_title, $forum->topic_count );
			$path = bbp_get_forum_permalink( $forum->ID );
			$this->add_sub_menu_item( $name, $path, $order++, 'forum' );
			$this->width = max( $this->width, ( mb_strlen( $forum->post_title . $forum->topic_count ) + 3 ) );
		}
	}

	/**
	 *  retrieve the forum title string.
	 *
	 * @since 20180905
	 * @uses bbp_get_forum_post_type_labels()
	 * @return string String bbPress as a menu title.
	 */
	protected function get_forums_title() {
		$labels = bbp_get_forum_post_type_labels();
		return $labels['menu_name'];
	}

	/**
	 *  Sort the forums.
	 *
	 * @since 20200502
	 * @param WP_Post $a  First object to sort.
	 * @param WP_Post $b  Second object to sort.
	 * @return int        Relative ranking.
	 */
	public function sort_forums( $a, $b ) {
		$value = 0;
		switch( $this->orderby ) {
			case 'post_title':
				$value = strcasecmp( $a->post_title, $b->post_title );
				break;
			case 'topic_count':
			default:
				$value = $a->topic_count - $b->topic_count;
		}
		$value = ( strtolower( $this->order ) === 'desc' ) ? -$value : $value;
		return $value;
	}

	protected function check_queried_object() {
		$object = get_queried_object();
		if ( ( $object instanceof WP_Post_Type ) && ( $object->name === $this->type ) ) {
			add_filter( 'nav_menu_css_class', [ $this, 'nav_menu_css_class' ], 100, 4 );
		}
	}

	public function nav_menu_css_class( $classes, $item, $args, $depth ) {
		if ( in_array( 'menu-item-type-forum', $classes ) && in_array( 'menu-item-has-children', $classes ) ) {
			$classes[] = 'current-menu-item';
		}
		return $classes;
	}

	/**
	 *  The function bbp_get_form_option() is normally only available on admin pages.
	 *
	 * @since 20180906
	 * @param string $option
	 * @param string $default
	 * @param bool $slug
	 * @return mixed
	 */
	public function bbp_get_form_option( $option, $default = '', $slug = false ) {
		if ( function_exists( 'bbp_get_form_option' ) ) {
			return bbp_get_form_option( $option, $default, $slug );
		}
		$value = get_option( $option, $default );
		if ( $slug ) {
			$value = esc_attr( apply_filters( 'editable_slug', $value ) );
		} else {
			$value = esc_attr( $value );
		}
		if ( empty( $value ) ) $value = $default;
		return apply_filters( 'bbp_get_form_option', $value, $option, $default, $slug );
	}


}
