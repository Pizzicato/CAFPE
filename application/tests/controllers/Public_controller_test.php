<?php
/**
 * Public_controller core controller Tests
 * @group controller
 */

class Public_controller_test extends TestCase
{
    public function test_When_requesting_public_actions_Then_login_not_needed()
    {
        unset($_SESSION);
        $this->request('GET', "/");
        $this->assertResponseCode(200);
        get_instance()->ion_auth->login('test', 'password');
    }

    public function test_When_requesting_public_actions_Then_title_is_set()
    {
        $output = $this->request('GET', "/en");
        $this->assertContains('<title>CAFPE - Centro Andaluz de Física de Partículas Elementales > Home</title>', $output);
        $output = $this->request('GET', "/en/news");
        $this->assertContains('<title>CAFPE - Centro Andaluz de Física de Partículas Elementales > News</title>', $output);
    }
}
