<?php
/**
 * Pages controller Tests
 * @group controller
 */

class Pages_test extends TestCase
{
    public function test_index()
    {
        $output = $this->request('GET', '/');
        $this->assertContains('This is the home page', $output);
    }
}
