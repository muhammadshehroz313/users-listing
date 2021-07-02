## Unit Testing

Unit testing of plugin is done with PHPUnit 7.5 and and WP-CLI. We have followed following procedure to perform unit testing.

To generate unit test files following command is executed.

wp scaffold plugin-tests wp-meta-verify

For WP-CLI, we installed a temporary WP instance with following command.

`bin/install-wp-tests.sh wp_trial_task db_user 'pwd' localhost latest`

Please change database name, database user, and database password as per your own setup.

We prepared a case in class `/plugins/users-listing/tests/PHPUnit/Unit/UsersListingBasicTest.php` for unit testing, verify structure of data returned by user detail API endpoint.
In testing class, an assertion is created with expected structure specified by developer, and tested against the data structure returned by the API endpoint.

## Coding Standards

We have tested the code with Inpsyde coding standard and updated the to fix major warnings. However, there are a few warnings left that are unavoidable as some JS scripts are external.

Testing performed with following parameters

`phpcs --standard=Inpsyde src/`


