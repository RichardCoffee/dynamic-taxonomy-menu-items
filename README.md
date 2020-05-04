
# Dynamic Taxonomy Menu Items

       Contributors: richard.coffee
               Tags: menu, dynamic menu, menubar, taxonomy, dynamic taxonomy
         Stable tag: 1.1.0
  Requires at least: 4.7.0
       Tested up to: 5.4.1
       Requires PHP: 5.3.6
            License: GPLv3
        License URI: http://www.gnu.org/licenses/gpl-3.0.html

Add a dynamic submenu to your WordPress menu.  Works with categories, tags, and bbPress forums.

## Description

This is a lightweight plugin to add a dynamic sub-menu to a WordPress menu.  It is known to work with [Nav Menu Roles](https://www.kathyisawesome.com/nav-menu-roles/).
Caution is indicated if trying to use it with a theme, menu plugin, or anything that makes significant changes to how the WordPress menu is handled. It can insert a
single sub-menu using any public taxonomy, such as catagories, tags, as well as woocommerce product categories or tags.  A seperate sub-menu for bbPress forums is
available.

## Installation

### Install from WordPress repository

1. In your admin dashboard, navigate to __Plugins->Add New__.
2. In the Search type __Dynamic Taxonomy__.  It showed up on page 3 last time I performed this search.
3. Locate this plugin in the list, and install it.
4. Activate the plugin via the prompt. A message should show confirming activation was successful.

### Manual Upload

1. Download the zip file from [WordPress](https://wordpress.org/plugins/dynamic-taxonomy-menu-items) or the plugin's [GitHub repository](https://github.com/RichardCoffee/dynamic-taxonomy-menu-items).
1. In your admin dashboard, navigate to __Plugins->Add New__.
2. Select the Upload option and hit "Choose File."
3. When the pop-up appears select the downloaded file.
4. Follow the on-screen instructions and upload the zip file.
5. Activate the plugin. WordPress should show an alert confirming activation was successful.

## Setup

The settings screen can be reached either via the settings link on the __Installed Plugins__ page, or via the __Dynamic Taxonomy__ option on the __Appearence__ menu.

The settings screen will enable you to control things like:

* Which menu the sub-menu is added to, default is the primary menu.
* Which taxonomy is displayed, default is categories.
* The title used for the sub-menu, default is 'Articles'.
* The position in the menu, default is to appear as the second menu item.
* The maximum number of items on the submenu, default is 7.
* Listing order of the sub-menu items, available is Term Name, Post Count (default), and Term ID.
* Which terms to exclude from the list, default is none, works for Category only (for now).
* Whether to include an item count on the sub-menu, default is yes.
* Items can also be limited by the count, ie: nothing with a count of less then N.  Default is 0.

The plugin also allows you to show bbPress forums, although those options are limited to:

* Which menu to add the forum list to.
* What position in the menu to take, default is the third menu item.
* What text to use as the menu option, default is 'Forums'.

## Development

If you wish to contribute, this plugin is can be found on [Github](https://github.com/RichardCoffee/dynamic-taxonomy-menu-items).

If you have an issue or question, the author can contacted via [opening an issue](https://github.com/RichardCoffee/dynamic-taxonomy-menu-items/issues) here on GitHub, or on the [WordPress support forum](https://wordpress.org/plugins/dynamic-taxonomy-menu-items).

Adding WooCommerce support is on the <kbd>todo</kbd> list.  Any help with this would be greatly appreciated.

## Changelog

### 1.1.0
* Certify:      Works with WordPress 5.4.1
* Enhancement:  Add bbPress Forums.
* Enhancement:  Combined options 'Order By' and 'Order Direction' into new option 'Item Order'.
* Upgrade:      Updated core files.

### 1.0.2
* Bugfix:  Settings screen spinners were not working properly.

### 1.0.1
* Minor:  Some code cleanup.

### 1.0.0
* Initial release.

