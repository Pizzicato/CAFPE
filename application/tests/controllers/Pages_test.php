<?php
/**
 * Pages controller Tests
 * @group controller
 */

class Pages_test extends TestCase
{
    public static function setUpBeforeClass()
    {
        parent ::setUpBeforeClass();
        $CI =& get_instance();
        $CI->load->library('Seeder');
        $CI->seeder->call('ArticleSeeder');
    }

    public function test_When_acces_index_Then_see_home_page()
    {
        $output = $this->request('GET', '/');
        $this->assertContains('This is the home page', $output);
    }

    public function test_When_acces_news_Then_see_articles_table()
    {
        $output = $this->request('GET', '/en/news');
        $this->assertContains('<h3>News</h3>', $output);
        $this->assertContains('<th>Date</th>', $output);
        $this->assertContains('<th>Title</th>', $output);
    }

    public function test_When_access_article_with_not_existing_slug_Then_get_404()
    {
        $invalid_slug = 'not-a-valid-slug';
        $output = $this->request('GET', "/en/article/$invalid_slug");
        $this->assertResponseCode(404);
    }

    public function test_When_access_article_with_existing_slug_Then_see_the_item()
    {
        $slug = 'title-en-slug-1';
        $output = $this->request('GET', "/en/article/$slug");
        $this->assertContains('<h3>Title en test 1</h3>', $output);
    }

    public function test_When_access_article_in_different_lang_Then_redirection_to_translated_URI()
    {
        $slug_en = 'title-en-slug-1';
        $slug_es = 'title-es-slug-1';
        $this->request('GET', "es/noticia/$slug_en");
        $this->assertRedirect("es/noticia/$slug_es", 302);
    }

    public function test_When_access_non_existent_article_in_different_lang_Then_see_error_message()
    {
        $slug_en = 'title-en-slug-3';
        $output = $this->request('GET', "es/noticia/$slug_en");
        $this->assertContains("<p>This article is not available in the selected language.</p>", $output);
    }
}
