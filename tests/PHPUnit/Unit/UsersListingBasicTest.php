<?php

declare(strict_types=1); # -*- coding: utf-8 -*-

class UsersListingBasicTest extends WP_UnitTestCase
{   
    /**
     * compare two json array structure data.
    */
    public function test_json_structure_verification()
    {
        $request = wp_remote_get('https://jsonplaceholder.typicode.com/users/1');
        $response = isset($request['response']) ? $request['response'] : '';
        if ($response['code'] == 200) {
            $actual_arr = json_decode($request['body'], True);
        }
        $expected_strucutre_json = '{"id":"","name":"","username":"","email":"","address":{"street":"","suite":"","city":"","zipcode":"","geo":{"lat":"","lng":""}},"phone":"","website":"","company":{"name":"","catchPhrase":"","bs":""}}';
        $expected_strucutre_arr = json_decode($expected_strucutre_json, True);
        $result_structure_array = array_diff_key($actual_arr, $expected_strucutre_arr);
        $this->assertEquals(array(), $result_structure_array);
    }
}
