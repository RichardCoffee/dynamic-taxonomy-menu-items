
# Dynamic Taxonomy Menu Items

**Contributors:** Richard
**Tags:** menu, taxonomy
**Stable tag:** 1.0.0
**Requires at least:** 4.7.0
**Tested up to:** 5.4
**Requires PHP:** 5.3.6
**License:** GPLv3
**License URI:** http://www.gnu.org/licenses/gpl-3.0.html

Add a dynamic taxonomy list to your WordPress menus.

## Description

This is a lightweight plugin to add a dynamic submenu of taxonomy items into a WordPress menu.  It is known to work with [Nav Menu Roles](https://www.kathyisawesome.com/nav-menu-roles/).
Caution is indicated if trying to use it with a theme, or menu plugin, that makes significant changes to the default WordPress menu.

## Installation

Install it via your site's admin dashboard->Add Plugins page, as usual.

If you want to install the plugin in another fashion, then I trust you know what you're doing.

## Setup

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

## Development

If you wish to contribute, this plugin is can be found on [Github](https://github.com/RichardCoffee/dynamic-taxonomy-menu-items).

## Changelog

### 1.0.0
* Initial release

