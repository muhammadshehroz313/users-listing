<?php

declare(strict_types=1);

// -*- coding: utf-8 -*-
/**
 * The template for displaying user details.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 */

get_header();

do_action('users_listing_add_table_header');
?>
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h2><?php echo esc_html(apply_filters('update_users_listing_title', 'Users Listing Table')); ?></h2>
        </div>
    </div>
    <br />
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="user-detail-background hidden"><span><i class="fa fa-refresh fa-spin"></i></span></div>
                <div class="panel-body">
                    <table class="table table-condensed table-striped users-listing-table">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">User Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($data as $userInfo) { ?>
                                <tr id="data-row-<?php echo esc_attr($userInfo->id); ?>">
                                    <td><a href="javascript:void(0)" data-user-id="<?php echo esc_attr($userInfo->id) ?>" class="fetch-user-detail"><?php echo esc_html($userInfo->id) ?></a></td>
                                    <td><a href="javascript:void(0)" data-user-id="<?php echo esc_attr($userInfo->id) ?>" class="fetch-user-detail"><?php echo esc_html($userInfo->name) ?></a></td>
                                    <td><a href="javascript:void(0)" data-user-id="<?php echo esc_attr($userInfo->id) ?>" class="fetch-user-detail"><?php echo esc_html($userInfo->username) ?></a></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- User Detail Model -->
<!-- Modal -->
<div id="user-detail-model" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">User Detail</h4>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-12">
                  <span class="msg modal-el"></span>
                </div>
              </div>
              <div class="user-details">
                <div class="row">
                <div class="col-md-4">
                    <h4>Name</h4>
                    <p class="modal-el" id= "name"></p>
                </div>
                <div class="col-md-4">
                    <h4>Email</h4>
                    <p class="modal-el" id= "email"></p>
                </div>
                <div class="col-md-4">
                    <h4>Phone</h4>
                    <p class="modal-el" id= "phone"></p>
                </div>
              </div>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <h4>Company Name</h4>
                        <p class="modal-el" id= "company_name"></p>
                    </div>
                    <div class="col-md-4">
                        <h4>Comapany Website</h4>
                        <p class="modal-el" id= "website"></p>
                    </div>
                </div>
                <hr>
                <div class="row">
                     <div class="col-md-12">
                        <h4>Address</h4>
                        <p class="modal-el" id= "address"></p>
                    </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
<?php

get_footer();

