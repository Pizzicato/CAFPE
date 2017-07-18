<?php
/**
 * News controller Tests
 * @group controller
 */

class News_test extends TestCase
{
    public function test_index()
    {
        $output = $this->request('GET', '/news');
        $this->assertContains('All news', $output);
    }
}
