<?php

declare(strict_types=1);

// -*- coding: utf-8 -*-

namespace PTInpsyde\UsersListing\Users;

use PTInpsyde\UsersListing\UsersListing;

/**
 * Class UsersListingTemplates
 *
 * Responsible for users listing template.
 *
 * @package PTInpsyde\UsersListing
 */

class UsersListingTemplates
{
    /**
     * Custom query variable.
     *
     * @var string
     */
    public const CUSTOMPAGEVAR = 'pt_custom_page';

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     */
    public function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'frontEndStyleScripts']);
        /**
         * Filter responsible for updating the User Listing template page title.
         *
         * @since 1.0.0
        */
        add_filter('pre_get_document_title', [$this, 'modifyUserListPageTitle'], 10, 1);
         /**
         * Filter responsible for rewriting the URL in your own pattern.
         *
         * @since 1.0.0
        */
        add_action('generate_rewrite_rules', [$this, 'rewriteURL']);
          /**
         * Filter responsible for registering query variable.
         *
         * @since 1.0.0
        */
        add_filter('query_vars', [$this, 'registerQueryVars'], 10);
    }

    /**
     * Load user data list template.
     *
     * @since    1.0.0
     * @access   public
     * @return    void
     */
    public function loadUsersTemplate(): void
    {
        /**
         * Filter responsible for adding the custom template for users listing.
         *
         * @since 1.0.0
        */
        add_action('template_redirect', [$this, 'userListTemplate']);
    }
    /**
     * Set template for users listing table
     *
     * @since    1.0.0
     * @access   public
     * @return void
     */

    public function userListTemplate(): void
    {
        $page = get_query_var(self::CUSTOMPAGEVAR);
        if ($page === $this->customEndpoint()) {
            $data = self::FetchUsersData();
            $userListingTemplate = plugin_dir_path(dirname(__FILE__)) . "views/listing-view/template-users-list.php";
            $this->themeRedirect($userListingTemplate, true, $data);
            exit();
        }
    }

    /**
     * Process theme redirect
     *
     * @param string $path
     * @param bool $force force redirect regardless of have_posts()
     * @param array $data vars to set for theme
     * @return void
     */

    public function themeRedirect(string $path, bool $force = false, array $data = []): void
    {
        global $wp_query;
        if (have_posts() || $force) {
            include($path);
            die();
        } else {
            $wp_query->is_404 = true;
        }
    }

    /**
     * get users data from 3rd party.
     *
     * @access public
     * @return array List of available users.
     */
    public static function fetchUsersData(): array
    {
        $response = get_transient('users_data_array');
        if (false === $response) {
            $request = wp_remote_get('https://jsonplaceholder.typicode.com/users/');
            $response = isset($request['response']) ? $request['response'] : '';
            if ($response['code'] === 200) {
                $response = json_decode($request['body']);
            }
            set_transient('users_data_array', $response, 3600);
        }
        return $response;
    }

    /**
     * Register all of the front styles and scripts
     * of the plugin.
     *
     * @since    1.0.0
     * @access   public
     * @return void
     */
    public function frontEndStyleScripts(): void
    {
        wp_enqueue_style('users-data-bootstrap', plugin_dir_url(dirname(__FILE__)) . 'assets/css/bootstrap.min.css', [], UsersListing::getVersion());
        wp_enqueue_style('users-data-fontawsome', plugin_dir_url(dirname(__FILE__)) . 'assets/css/font-awesome.min.css', [], UsersListing::getVersion());
        wp_enqueue_style('users-data-styles', plugin_dir_url(dirname(__FILE__)) . 'assets/css/users-data.css', [], UsersListing::getVersion());
        //
        wp_enqueue_script('jquery-min', plugin_dir_url(dirname(__FILE__)) . 'assets/js/jquery.min.js', ['jquery'], UsersListing::getVersion(), false);
        wp_enqueue_script('jquery-popper', plugin_dir_url(dirname(__FILE__)) . 'assets/js/popper.min.js', ['jquery'], UsersListing::getVersion(), false);
        wp_enqueue_script('bootstrap-min', plugin_dir_url(dirname(__FILE__)) . 'assets/js/bootstrap.min.js', ['jquery'], UsersListing::getVersion(), false);
    }
    /**
     * Filters the text of the users list page title.
     * @access public
     * @param string $title Page title.
     * @return string update page title.
     */

    public function modifyUserListPageTitle(string $title): string
    {
        global $wp;
        if ($wp->request === $this->customEndpoint()) {
            $title = 'Users List';
        }
        return $title;
    }

    /**
     * set custom end point slug which also contains a filter to modify the slug.
     * @access public
     * @return string update page title.
     */

    public function customEndpoint(): string
    {
        $customEndpoint = 'user-data';
        $customEndpoint = apply_filters('update_userlist_endpoint', $customEndpoint, 20);
        return $customEndpoint;
    }

    /**
     * Create re-write rule for arbitrary url.
     * @access public
     * @return void
     */
    public function rewriteURL(): void
    {
        global $wp_rewrite;
        $customEndpoint = $this->customEndpoint();
        $newRules = [
            $customEndpoint . '/?$' => 'index.php?' . self::CUSTOMPAGEVAR . '=' . $customEndpoint,
        ];
        $wp_rewrite->rules = $newRules + (array) $wp_rewrite->rules;
    }

    /**
     * Register custom query vars
     *
     * @param array $vars The array of available query variables
     *
     * @return array
     *
     */
    public function registerQueryVars(array $vars): array
    {
        $vars[] = self::CUSTOMPAGEVAR;
        return $vars;
    }
}
