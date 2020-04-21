
=== Dynamic Taxonomy Menu Items ===

Contributors: richard.coffee
Tags: menu, menubar, taxonomy
Stable tag: 1.0.1
Requires at least: 4.7.0
Tested up to: 5.4
Requires PHP: 5.3.6
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Add a dynamic taxonomy list to your WordPress menus.

== Description ==

This is a lightweight plugin to add a dynamic submenu of taxonomy items into a WordPress menu.  It is known to work with [Nav Menu Roles](https://www.kathyisawesome.com/nav-menu-roles/).
Caution is indicated if trying to use it with a theme, or menu plugin, that makes significant changes to the default WordPress menu.

== Installation ==

= Install from WordPress repository =

1. In your admin dashboard, navigate to 'Plugins->Add New'.
2. In the Search type 'Dynamic Taxonomy'.
3. Locate this plugin in the list, and install it.
4. Activate the plugin via the prompt. A message should show confirming activation was successful.

= Manual Upload =

1. Download the zip file from [WordPress](https://wordpress.org/plugins/dynamic-taxonomy-menu-items) or the plugin's [GitHub repository](https://github.com/RichardCoffee/dynamic-taxonomy-menu-items).
1. In your admin dashboard, navigate to 'Plugins->Add New'.
2. Select the Upload option and hit "Choose File."
3. When the pop-up appears select the downloaded file.
4. Follow the on-screen instructions and upload the zip file.
5. Activate the plugin. A message should show confirming activation was successful.

== Setup ==

Simply activating the plugin will, by default, add a category sub-menu to your primary menu.  The settings screen can be reached either via the settings link on the _Installed Plugins_ page, or via the _Dynamic Taxonomy_ option on the _Appearence_ menu.

The settings screen will enable you to control things like:

* Which menu the sub-menu is added to, default is the primary menu.
* Which taxonomy is displayed, default is categories.
* The title used for the sub-menu, default is 'Articles'.
* The position in the menu, default is to appear as the second menu item.
* The maximum number of items on the submenu, default is 7.
* Listing order of the sub-menu items, available is Term Name, Post Count (default), and Term ID.
* Which terms to exclude from the list, default is none.
* Whether to include an item count on the sub-menu, default is yes.
* Items can also be limited by the count, ie: nothing with a count of less then N.  Default is 0.

== Development ==

If you wish to contribute, this plugin is can be found on [Github](https://github.com/RichardCoffee/dynamic-taxonomy-menu-items).

If you have an issue or question, the author can contacted on the [WordPress support forum](https://wordpress.org/support/plugin/dynamic-taxonomy-menu-items/) or via [opening an issue on GitHub](https://github.com/RichardCoffee/dynamic-taxonomy-menu-items/issues).

== Changelog ==

= 1.0.1 =
* Minor:  Some code cleanup.

= 1.0.0 =
* Initial release

