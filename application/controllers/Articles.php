<?php defined('BASEPATH') or exit('No direct script access allowed');

class Articles extends Auth_controller
{
    public function __construct()
    {
        parent ::__construct();
        $this->load->model('article_model');
    }

    /**
     * Maps to:
     *    - base_url + articles
     *    - base_url + articles/index
     */
    public function index()
    {
        $articles = $this->article_model->get_all();
        $this->data['articles'] = $articles;
    }

    /**
     * Maps to:
     *    - base_url + articles/view/$slug
     */
    public function view($slug = null)
    {
        // TODO: slug depending
        $article = $this->article_model->with_slug($slug)->get();
        if (! $article) {
            show_404();
        }

        $this->data = array_merge($this->data, $article);
    }

    /**
     * Maps to:
     *    - base_url + articles/create
     */
    public function create()
    {
        $this->load->helper('form');

        $id = $this->article_model->from_form()->insert();
        if ($id) {
            redirect('articles/');
        }
    }
}
