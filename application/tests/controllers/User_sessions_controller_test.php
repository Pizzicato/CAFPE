<?php
/**
 * Articles controller Tests
 * @group controller
 */

class User_sessions_controller_test extends TestCase
{
    public static function setUpBeforeClass()
    {
        parent ::setUpBeforeClass();
        $CI =& get_instance();
        $CI->load->library('Seeder');
        $CI->seeder->call('ArticleSeeder');
    }

    public function test_When_create_valid_session_Then_redirect_to_dashboard()
    {
        $output = $this->request(
            'POST',
            '/en/admin/login',
            array(
                'username' => 'test',
                'password' => 'password'
            )
        );
        $this->assertRedirect('en/admin/dashboard', 302);
    }

    public function test_When_post_invalid_session_form_fields_Then_show_errors()
    {
        $output = $this->request(
            'POST',
            '/en/admin/login',
            array(
                'username' => '',
                'password' => ''
            )
        );
        $this->assertContains("The Username field is required", $output);
        $this->assertContains("The Password field is required", $output);
    }

    public function test_When_post_invalid_credentials_Then_show_error()
    {
        $output = $this->request(
            'POST',
            '/en/admin/login',
            array(
                'username' => 'test',
                'password' => 'wrong_password'
            )
        );
        $this->assertContains("Incorrect Login", $output);
    }

    public function test_When_delete_session_Then_get_logged_out_and_redirected_to_current_URL()
    {
        // invalid id, but cannot test redirect content
        $url = '/en/news/';
        $encoded_url = strtr(base64_encode($url), '+/=', '._-');
        $this->request('GET', "/en/admin/logout/$encoded_url");
        $this->assertRedirect($url, 302);
    }
}
