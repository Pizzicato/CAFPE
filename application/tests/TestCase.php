<?php

class TestCase extends CIPHPUnitTestCase
{
    private static $migrated = false;

    public static function setUpBeforeClass()
    {
        parent ::setUpBeforeClass();
        $CI =& get_instance();
        // Run migrations once
        if (! self::$migrated) {
            $CI->load->database();
            $CI->load->library('migration');
            if ($CI->migration->latest() === false) {
                throw new RuntimeException($this->migration->error_string());
            }
            self::$migrated = true ;
        }
        // seed users and login test user
        $CI->load->add_package_path(APPPATH.'libraries/ionauth/');
        $CI->load->library('Seeder');
        $CI->seeder->call('UserSeeder');
        $CI->load->library('ion_auth');
        $CI->ion_auth->login('test', 'password');
    }
}
