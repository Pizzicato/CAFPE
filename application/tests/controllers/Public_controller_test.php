<?php
/**
 * Public_controller core controller Tests
 * @group controller
 */

class Public_controller_test extends TestCase
{
    public function test_login_not_needed()
    {
        unset($_SESSION);
        $this->request('GET', "/");
        $this->assertResponseCode(200);
        get_instance()->ion_auth->login('test', 'password');
    }

    public function test_template()
    {
        $this->markTestIncomplete('This test has not been implemented yet.');
    }
}
