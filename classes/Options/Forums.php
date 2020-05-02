<?php
/**
 *  Provides options layout for Forums settings.
 *
 * @package DynTaxMI
 * @subpackage Forms
 * @since 20200425
 * @author Richard Coffee <richard.coffee@rtcenterprises.net>
 * @copyright Copyright (c) 2020, Richard Coffee
 * @link https://github.com/RichardCoffee/dynamic-taxonomy-menu-items/blob/master/classes/Options/Forums.php
 */
defined( 'ABSPATH' ) || exit;


class DynTaxMI_Options_Forums extends DynTaxMI_Options_Options {


	/**
	 * @since 20200408
	 * @var string  Used as suffix for database option name field.
	 */
	protected $base = 'bbpress';
	/**
	 * @since 20200408
	 * @var int  Controls order on tabbed screen.
	 */
	protected $priority = 810;


	/**
	 *  Returns the form title.
	 *
	 * @since 20200425
	 * @return string
	 */
	protected function form_title() {
		return __( 'bbPress Forums', 'dyntaxmi' );
	}

	/**
	 *  Returns the CSS for the dashicon for a tabbed screen.
	 *
	 * @since 20200425
	 * @return string
	 */
	protected function form_icon() {
		return 'dashicons-buddicons-forums';
	}

	/**
	 *  Displays description text.
	 *
	 * @since 20200425
	 */
	public function describe_options() {
		esc_html_e( 'These options control the settings for the bbPress forums menu.', 'dyntaxmi' );
	}

	/**
	 *  Returns the layout for the settings screen.
	 *
	 * @since 20200425
	 * @return array  Form layout
	 */
	protected function options_layout() {
		return array(
			'active' => array(
				'default' => 0,
				'label'   => __( 'Usage', 'dyntaxmi' ),
				'text'    => __( 'Check here to add a submenu of bbPress forums.', 'dyntaxmi' ),
				'render'  => 'checkbox',
			),
			'menu' => array(
				'default' => 'primary-menu',
				'label'   => __( 'Menu', 'dyntaxmi' ),
				'text'    => __( 'Choose the menu to add the sub-menu to, default is the Primary Menu.', 'dyntaxmi' ),
				'render'  => 'select',
				'source'  => dyntaxmi()->get_menus(),
			),
			'title' => array(
				'default' => __( 'Forums', 'dyntaxmi' ),
				'label'   => __( 'Sub-Menu Title', 'dyntaxmi' ),
				'place'   => __( 'Sub-Menu Title', 'dyntaxmi' ),
				'text'    => __( 'This will be the text that appears on the main menu option.', 'dyntaxmi' ),
				'render'  => 'text',
			),
			'position' => array(
				'default' => 2,
				'label'   => __( 'Position', 'dyntaxmi' ),
				'text'    => __( 'Position in the menu. Starts at 0, defaults to 1.', 'dyntaxmi' ),
				'help'    => __( 'You may need to experiment with this number to get the sub-menu show up where you want it to.', 'dyntaxmi' ),
				'render'  => 'spinner',
				'attrs'   => array(
					'min' => '0',
					'max' => dyntaxmi()->max_count, // TODO:  get a top level count. use js to match chosen menu.
				),
			),
		);
	}

	/**
	 *  Filter the standard form text.
	 *
	 * @since 20200426
	 * @param  array $text  The form text.
	 * @return array        The filtered text.
	 */
	public function form_text_filter( $text ) {
		$text['submit']['object']  = __( 'Forums', 'dyntaxmi' );
		$text['submit']['subject'] = __( 'Forums', 'dyntaxmi' );
		return $text;
	}


}
