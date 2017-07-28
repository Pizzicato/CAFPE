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

    public function test_When_searching_by_slug_Then_both_slug_columns_are_used()
    {
        $result_en = $this->obj->with_slug('title-en-slug-1')->get();
        $result_es = $this->obj->with_slug('title-es-slug-1')->get();
        $this->assertInternalType('array', $result_en);
        $this->assertInternalType('array', $result_es);
        $this->assertSame($result_en, $result_es);
    }

    public function test_When_inserting_Then_date_is_required_with_valid_format()
    {
        $_POST = ['title_es' => 'Title es', 'lang' => 'es'];
        $this->assertFalse($this->obj->from_form()->insert());
        $this->CI->form_validation->reset_validation();

        $_POST['date'] = date('Y-m-');
        $this->assertFalse($this->obj->from_form()->insert());
        $this->CI->form_validation->reset_validation();

        $_POST['date'] = date('Y-m-d');
        $this->assertInternalType("int", $this->obj->from_form()->insert());
        $this->CI->form_validation->reset_validation();
    }

    public function test_When_inserting_Then_lang_has_to_be_es_en_or_all()
    {
        $_POST = ['title_es' => 'Title es', 'title_en' => 'Title en', 'lang' => 'invalid', 'date' => date('Y-m-d')];
        $this->assertFalse($this->obj->from_form()->insert());
        $this->CI->form_validation->reset_validation();

        foreach ( ['en', 'es', 'all'] as $lang) {
            $_POST['lang'] = $lang;
            $this->assertInternalType("int", $this->obj->from_form()->insert());
            $this->CI->form_validation->reset_validation();
        }
    }

    public function test_When_inserting_Then_title_has_to_be_defined_depending_on_lang()
    {
        $_POST = ['title_es' => 'Title es', 'lang' => 'en', 'date' => date('Y-m-d')];
        $this->assertFalse($this->obj->from_form()->insert());
        $this->CI->form_validation->reset_validation();

        $_POST = ['title_es' => '', 'title_en' => 'Title en', 'lang' => 'es', 'date' => date('Y-m-d')];
        $this->assertFalse($this->obj->from_form()->insert());
        $this->CI->form_validation->reset_validation();

        $_POST['lang'] = 'all';
        $this->assertFalse($this->obj->from_form()->insert());
        $this->CI->form_validation->reset_validation();

        $_POST = ['title_en' => '', 'title_es' => 'Title es', 'lang' => 'es', 'date' => date('Y-m-d')];
        $this->assertInternalType("int", $this->obj->from_form()->insert());
        $this->CI->form_validation->reset_validation();

        $_POST = ['title_es' => '', 'title_en' => 'Title en', 'lang' => 'en', 'date' => date('Y-m-d')];
        $this->assertInternalType("int", $this->obj->from_form()->insert());
        $this->CI->form_validation->reset_validation();

        $_POST = ['title_es' => 'Title es', 'title_en' => 'Title en', 'lang' => 'all', 'date' => date('Y-m-d')];
        $this->assertInternalType("int", $this->obj->from_form()->insert());
        var_dump(validation_errors());
        $this->CI->form_validation->reset_validation();
    }

    public function test_When_inserting_Then_main_pic_has_to_be_extracted_from_content()
    {
        $_POST = ['title_en' => 'Title en', 'lang' => 'en', 'date' => date('Y-m-d'), 'content_en' => 'no pic'];
        $this->assertInternalType("int", $this->obj->from_form()->insert());

        $this->CI->form_validation->reset_validation();
    }

    // public function test_When_inserting_Then_slugs_have_to_be_created_from_titles()
    // {
    //     $result_en = $this->obj->with_slug('title-en-slug-1')->get();
    //     $result_es = $this->obj->with_slug('title-es-slug-1')->get();
    //     $this->assertInternalType('array', $result_en);
    //     $this->assertInternalType('array', $result_es);
    //     $this->assertSame($result_en, $result_es);
    // }
}
