<?php

class TestCase extends CIPHPUnitTestCase
{
    private static $migrated = false;

    public static function setUpBeforeClass()
    {
        parent ::setUpBeforeClass();
        // Run migrations once
        if (! self::$migrated) {
            $CI =& get_instance();
            $CI->load->database();
            $CI->load->library('migration');
            if ($CI->migration->latest() === false) {
                throw new RuntimeException($this->migration->error_string());
            }
            self::$migrated = true ;
        }
    }
}
