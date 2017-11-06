<?php

/**
 * Slug library Tests
 * @group library
 */

class Slug_library_test extends TestCase
{
    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        $CI =& get_instance();
        $CI->load->library('Seeder');
        $CI->seeder->call('ArticleSeeder');
    }

    public function setUp()
    {
        $this->resetInstance();
        $this->CI->load->library('slug', array('table' => 'articles'));
        $this->CI->load->model('article_model');
        $this->article = $this->CI->article_model;
        $this->obj = $this->CI->slug;
    }

    public function test_When_creating_slug_from_new_title_Then_title_with_dashes()
    {
        $slug =  $this->obj->create_uri('New title, not in DB', 'slug_es');
        $this->assertSame($slug, 'new-title-not-in-db');
    }

    public function test_When_creating_slug_from_existent_title_in_db_Then_adds_numbers_to_slug()
    {
        $slug =  $this->obj->create_uri('Title es test 1', 'slug_es');
        $this->assertSame($slug, 'title-es-test-1-1');
        $this->article->insert(array('title_es' => 'Title es test 1', 'content_es' => 'content', 'date' => date('d-m-Y')));
        $slug =  $this->obj->create_uri('Title es test 1', 'slug_es');
        $this->assertSame($slug, 'title-es-test-1-2');
    }
}
