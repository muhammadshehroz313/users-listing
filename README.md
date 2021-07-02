# WP External Users Listing

WP External Users Listing is a sample functionality plugin that display users in custom endoint based template.
The template displays a table having common fields. On click on any of the cells it open a popup with detail of the user.

## Installation

This plugin is a composer package that will be installed as a `wordpress-plugin`. As such, there are a few things to note when attempting to install it.
WP Exteranl Users Listing assumes it's living in a subfolder, it contains a lot of other dev-related stuff in its root folder.

For WP to pick up External User Listing as a plugins folder, you have to do one of the following:
Go to wp-content/plugins/ in your WordPress installation and clone repo from https://github.com/presstigers-inpsyde/users-listing.
After clone, go to users-listing folder created by git clone and run `composer install`. It will generate autoload files to load plugins instance.
Plugin will ready to activate after following above steps.

## Usage

After activating plugin, flush permalink settings from wp-admin and use `user-data` endpoint like http://www.yourwebsite.com/user-data to laod user listing template.

## Extension

User listing template loads at custom endpoint `user-data` which can be overided by hooks `update_userlist_endpoint`
To update template page title `update_users_listing_title` hook is avaialbe.
`users_listing_add_table_header` hook is avaialbe for adding html structure above the users listing table.

## License and Copyright

Copyright (c) 2021 PressTigers.

PTInpsyde code is licensed under [MIT license](./LICENSE).

[PressTigers](https://presstigers.com/) is known within the WordPress community for our services covering theme design and custom coding.
