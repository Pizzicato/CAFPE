<?php
/**
 * Auth_controller core controller Tests
 * @group controller
 */

class Auth_controller_test extends TestCase
{
    public function test_When_accessing_restricted_area_not_logged_in_Then_redirection()
    {
        unset($_SESSION);
        $this->request('GET', "/en/admin/");
        $this->assertRedirect('en/admin/login', 302);
        get_instance()->ion_auth->login('test', 'password');
    }

    public function test_template()
    {
        $this->markTestIncomplete('This test has not been implemented yet.');
    }
}
