<?php

/**
 * Article model Tests
 * @group model
 */

class Article_model_test extends TestCase
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
        $this->CI->load->model('article_model');
        $this->obj = $this->CI->article_model;
        $_SERVER['REQUEST_METHOD'] = 'post';
    }

    public function reset_model()
    {
        $this->resetInstance();
        $this->CI->load->model('article_model');
        $this->obj = $this->CI->article_model;
    }

    public function test_When_searching_by_slug_Then_both_slug_columns_are_used()
    {
        $result_en = $this->obj->where_slug('title-en-test-1')->get();
        $result_es = $this->obj->where_slug('title-es-test-1', 'es')->get();
        $this->assertInternalType('array', $result_en);
        $this->assertInternalType('array', $result_es);
        $this->assertSame($result_en, $result_es);
    }

    public function test_When_getting_data_by_lang_correct_records_are_returned()
    {
        $articles = $this->obj->get_all_lang('es', 'date');
        $this->assertInternalType('array', $articles);
        $this->assertCount(2, $articles);
        foreach ($articles as $article) {
            $this->assertArrayHasKey('title', $article);
            $this->assertArrayHasKey('content', $article);
            $this->assertArrayHasKey('slug', $article);
        }
    }

    public function test_When_getting_language_of_a_slug_the_returned_language_is_correct()
    {
        $lang = $this->obj->slug_lang('title-es-test-1');
        $this->assertSame($lang, 'es');
        $lang = $this->obj->slug_lang('title-en-test-1');
        $this->assertSame($lang, 'en');
        $lang = $this->obj->slug_lang('not-valid-slug');
        $this->assertFalse($lang);
    }

    public function test_When_inserting_Then_date_is_required_with_valid_format()
    {
        $_POST = ['title_es' => 'Date check', 'content_es' => 'Date check content'];
        $this->reset_model();
        $this->assertFalse($this->obj->from_form()->insert());
        $this->CI->form_validation->reset_validation();

        $_POST['date'] = date('Y-m-d');
        $this->reset_model();
        $this->assertFalse($this->obj->from_form()->insert());
        $this->CI->form_validation->reset_validation();

        $_POST['date'] = date('d-m-Y');
        $this->reset_model();
        $this->assertInternalType("int", $this->obj->from_form()->insert());
        $this->CI->form_validation->reset_validation();
    }


    public function test_When_inserting_Then_at_least_content_and_title_of_one_lang_have_to_be_filled()
    {
        $_POST = ['title_es' => 'Title check 1', 'date' => date('d-m-Y')];
        $this->reset_model();
        $this->assertFalse($this->obj->from_form()->insert());
        $this->CI->form_validation->reset_validation();

        $_POST = ['title_en' => 'Title check 2', 'date' => date('d-m-Y')];
        $this->reset_model();
        $this->assertFalse($this->obj->from_form()->insert());
        $this->CI->form_validation->reset_validation();

        $_POST = ['content_es' => 'Content check 1', 'date' => date('d-m-Y')];
        $this->reset_model();
        $this->assertFalse($this->obj->from_form()->insert());
        $this->CI->form_validation->reset_validation();

        $_POST = ['content_en' => 'Content check 2', 'date' => date('d-m-Y')];
        $this->reset_model();
        $this->assertFalse($this->obj->from_form()->insert());
        $this->CI->form_validation->reset_validation();

        $_POST = ['title_es' => 'Title and content check 1', 'content_es' => 'Title and content check 1', 'date' => date('d-m-Y')];
        $this->reset_model();
        $this->assertInternalType("int", $this->obj->from_form()->insert());
        $this->CI->form_validation->reset_validation();

        $_POST = ['title_en' => 'Title and content check 1', 'content_en' => 'Title and content check 1', 'date' => date('d-m-Y')];
        $this->reset_model();
        $this->assertInternalType("int", $this->obj->from_form()->insert());
        $this->CI->form_validation->reset_validation();
    }

    public function test_When_inserting_Then_main_pic_has_to_be_extracted_from_content()
    {
        $_POST = ['title_es' => 'Pic check', 'content_es' => 'No PIC', 'date' => date('d-m-Y')];
        $this->reset_model();
        $this->obj->from_form()->insert();
        $last = $this->obj->get($this->obj->db->insert_id());
        $this->assertNull($last['main_pic']);
        $this->CI->form_validation->reset_validation();

        $_POST['content_es'] = 'Pic this time <img src="smiley.gif" alt="Smiley face" height="42" width="42">';
        $this->reset_model();
        $this->obj->from_form()->insert();
        $last = $this->obj->get($this->obj->db->insert_id());
        $this->assertSame('smiley.gif', $last['main_pic']);
        $this->CI->form_validation->reset_validation();
    }

    public function test_When_inserting_Then_slugs_have_to_be_created_from_titles()
    {
        $_POST = ['title_en' => 'Slug check', 'content_en' => 'Slug check', 'date' => date('d-m-Y')];
        $this->reset_model();
        $this->obj->from_form()->insert();
        $last = $this->obj->get($this->obj->db->insert_id());
        $slug = $this->CI->slug->create_slug($_POST['title_en']);
        $this->assertSame($slug, $last['slug_en']);
    }
}
