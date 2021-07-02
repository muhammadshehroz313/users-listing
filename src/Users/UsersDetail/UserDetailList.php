<?php

declare(strict_types=1);

// -*- coding: utf-8 -*-

namespace PTInpsyde\UsersListing\Users\UsersDetail;

use PTInpsyde\UsersListing\UsersListing;

/**
 * Class UserDetailList
 *
 * Responsible for users listing Ajax.
 *
 * @package PTInpsyde\UsersListing
 */

class UserDetailList
{
    /**
     * Action hook used by the AJAX class.
     *
     * @var string
     */
    public const ACTION = 'users_listing_get_user_detail';

    /**
     * Action argument used by the nonce validating the AJAX request.
     *
     * @var string
     */
    public const NONCE = 'users-listing-ajax';

    /**
     * Register the AJAX handler class with all the appropriate WordPress hooks.
     * @return void
     */
    public function register(): void
    {
        $handler = new self();
        add_action('wp_ajax_' . self::ACTION, [$handler, 'handle']);
        add_action('wp_ajax_nopriv_' . self::ACTION, [$handler, 'handle']);
        add_action('wp_enqueue_scripts', [$handler, 'registerScript']);
    }

    /**
     * Handles the AJAX request
     * @return void
     */

    public function handle(): void
    {
        try {
            //
            $nonce = isset($_POST['_ajax_nonce']) ? sanitize_text_field(wp_unslash($_POST['_ajax_nonce'])) : '';
            if (!wp_verify_nonce($nonce, self::NONCE)) {
                throw new \Exception("<h4>Requested token has been expired, New Nonce Has been generated. Please click again on the user.</h4>");
            }
            $userId = isset($_POST['user_id']) ? sanitize_text_field(wp_unslash($_POST['user_id'])) : '';
            $newAjaxNonce = wp_create_nonce(UserDetailList::NONCE);
            $request = wp_remote_get('https://jsonplaceholder.typicode.com/users/' . $userId);
            //
            $response = isset($request['response']) ? $request['response'] : '';
            if ($response['code'] === 404) {
                throw new \Exception("<h4>Error 404! Request doesn't exists.</h4>");
            }
            $response = json_decode($request['body']);
            echo json_encode(['res' => $response, 'new_nonce' => $newAjaxNonce]);
            wp_die();
        } catch (\Exception $error) {
            echo json_encode(['error' => true, 'message' =>  $error->getMessage()]);
            wp_die();
        }
    }

    /**
     * Register our AJAX JavaScript.
     * @return void
     */
    public function registerScript(): void
    {
        wp_register_script('wp_ajax', plugin_dir_url(__DIR__) . 'src/../../assets/js/users-listing-functions.js', ['jquery'], UsersListing::getVersion(), false);
        wp_localize_script('wp_ajax', 'users_listing_plugin_vars', $this->getAjaxData());
        wp_enqueue_script('wp_ajax');
    }

    /**
     * Get the AJAX data that WordPress needs to output.
     *
     * @return array
     */
    private function getAjaxData(): array
    {
        return [
            'action' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce(UserDetailList::NONCE),
        ];
    }
}
