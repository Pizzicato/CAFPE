<?php
/**
 * Pages controller Tests
 * @group controller
 */

class Private_Pages_test extends TestCase
{
    public function test_When_acces_index_Then_see_home_page()
    {
        $output = $this->request('GET', 'en/admin/dashboard');
        $this->assertContains('<h3>My Dashboard</h3>', $output);
    }
}
