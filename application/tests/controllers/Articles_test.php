<?php
/**
 * Articles controller Tests
 * @group controller
 */

class Articles_test extends TestCase
{
    public function test_index()
    {
        $output = $this->request('GET', '/articles');
        $this->assertContains('<h3>News</h3>', $output);
    }
}
