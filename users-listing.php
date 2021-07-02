<?php # -*- coding: utf-8 -*-

/**
 * Plugin Name: WP External User Listing
 * Plugin URI: https://github.com/presstigers-inpsyde/users-listing
 * Description: WP External Users Listing is a sample functionality plugin that display users in custom endoint based template
 * Version: 1.0
 * Author: PressTigers
 * Author URI: https://www.presstigers.com
 * License: MIT
 */


namespace PTInpsyde\UsersListing;

if (!class_exists(UsersListing::class) && is_readable(__DIR__ . '/vendor/autoload.php')) {
    /** @noinspection PhpIncludeInspection */
    require_once __DIR__ . '/vendor/autoload.php';
}

class_exists(UsersListing::class) && UsersListing::instance();
