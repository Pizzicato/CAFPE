<?php
/**
 * Articles controller Tests
 * @group controller
 */

class Articles_test extends TestCase
{
    public static function setUpBeforeClass()
    {
        parent ::setUpBeforeClass();
        $CI =& get_instance();
        $CI->load->library('Seeder');
        $CI->seeder->call('ArticleSeeder');
    }

    public function test_When_access_articles_Then_see_articles_table()
    {
        $output = $this->request('GET', '/en/admin/articles');
        $this->assertContains('<h3>News</h3>', $output);
        $this->assertContains('<th>Date</th>', $output);
        $this->assertContains('<th>Title</th>', $output);
    }

    public function test_When_access_article_with_not_existing_id_Then_get_404()
    {
        $id = 56;
        $output = $this->request('GET', "/en/admin/articles/view/$id");
        $this->assertResponseCode(404);
    }

    public function test_When_access_article_with_existing_id_Then_see_the_item()
    {
        $id = 1;
        $output = $this->request('GET', "/en/admin/articles/view/$id");
        // articles has to be in English or/and Spanish
        $this->assertRegExp('/<h3>(English|Spanish)\:/', $output);
    }

    public function test_When_create_valid_article_item_Then_redirect_to_created_item()
    {
        $output = $this->request(
            'POST',
            '/en/admin/articles/create',
            array(
                'date' => '20-10-2019',
                'title_en' => 'A very nice title',
                'content_en' => 'Veeery long content, non stop informing the world attitude'
            )
        );
        $this->assertRedirect('en/admin/articles/view/4', 302);
    }

    public function test_When_access_articles_Then_see_four_articles()
    {
        $output = $this->request('GET', '/en/admin/articles');
        // 4 element + thead row
        $this->assertEquals(substr_count($output,'<tr>'), 5);
    }

    public function test_When_create_invalid_article_item_Then_show_errors()
    {
        $output = $this->request(
            'POST',
            '/en/admin/articles/create',
            array()
        );
        $this->assertContains("Article title and content have to be filled in in at least one of the available languages", $output);
    }

    public function test_When_edit_article_with_not_existing_id_Then_get_404()
    {
        $id = 45;
        $output = $this->request('GET', "/en/admin/articles/edit/$id");
        $this->assertResponseCode(404);
    }

    public function test_When_edit_valid_article_item_Then_redirect_to_edited_item()
    {
        $id = 4;
        $this->request(
            'POST',
            "/en/admin/articles/edit/$id",
            array(
                'date' => '20-10-2019',
                'title_en' => 'Changed but also nice title',
                'content_en' => 'Veeery long content, non stop informing the world attitude'
            )
        );
        $this->assertRedirect('en/admin/articles/view/4', 302);
    }

    public function test_When_access_edited_article_Then_see_the_changes()
    {
        $id = 4;
        $output = $this->request('GET', "/en/admin/articles/view/$id");
        // articles has to be in English or/and Spanish
        $this->assertContains('Changed but also nice title', $output);
    }

    public function test_When_edit_invalid_article_item_Then_redirect_to_edited_item()
    {
        $id = 4;
        $output = $this->request(
            'POST',
            "/en/admin/articles/edit/$id",
            array()
        );
        $this->assertContains("Article title and content have to be filled in in at least one of the available languages", $output);
    }

    public function test_When_delete_invalid_article_Then_get_redirect_and_number_of_articles_is_the_same()
    {
        // invalid id, but cannot test redirect content
        $id = 45;
        $this->request('GET', "/en/admin/articles/delete/$id");
        $this->assertRedirect('en/admin/articles', 302);
        $output = $this->request('GET', '/en/admin/articles');
        // 4 element + thead row
        $this->assertEquals(substr_count($output,'<tr>'), 5);
    }

    public function test_When_delete_valid_article_Then_get_redirect_and_number_of_articles_is_one_less()
    {
        // invalid id, but cannot test redirect content
        $id = 4;
        $this->request('GET', "/en/admin/articles/delete/$id");
        $output = $this->request('GET', '/en/admin/articles');
        // 3 element + thead row
        $this->assertEquals(substr_count($output,'<tr>'), 4);
    }
}
