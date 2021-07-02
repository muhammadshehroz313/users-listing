<?php

declare(strict_types=1);

// -*- coding: utf-8 -*-

namespace PTInpsyde\UsersListing;

use PTInpsyde\UsersListing\Users\UsersListingTemplates;
use PTInpsyde\UsersListing\Users\UsersDetail\UserDetailList;

/**
 * Class UsersListing
 *
 * @package PTInpsyde\UsersListing
 */
final class UsersListing
{
    /**
     * @var string
     */
    private static $version;

    /**
     * @return UsersListing
     *
     */
    public static function instance(): self
    {
        static $instance;
        if (!$instance) {
            $instance = new self();
            $instance->init();
        }
        return $instance;
    }

    /**
     * Initialize
     * @access private
     */

    private function init()
    {
        if (wp_installing()) {
            return;
        }
        self::$version = '1.0';
        $this->usersListingTemplate()->loadUsersTemplate();
        $this->userDetailList()->register();
    }

    /**
     * Load users listing Template.
     *
     * @return UsersListingTemplates
     */
    public function usersListingTemplate(): UsersListingTemplates
    {
        return new UsersListingTemplates();
    }

    /**
     * Load user detail ajax Template.
     *
     * @return UserDetailList
     */
    public function userDetailList(): UserDetailList
    {
        return new UserDetailList();
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public static function getVersion(): string
    {
        return self::$version;
    }
}
