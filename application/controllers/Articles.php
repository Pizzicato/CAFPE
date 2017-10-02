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
     *    - site_url + articles
     *    - site_url + articles/index
     */
    public function index()
    {
        $this->data['articles'] = [];
        $articles = $this->article_model->order_by('date', 'DESC')->get_all();
        if($articles) {
            $this->data['articles'] = $articles;
        }
    }

    /**
     * Maps to:
     *    - site_url + articles/view/$slug
     */
    public function view($id)
    {
        $article = $this->article_model->get($id);
        if (! $article) {
            show_404();
        }

        $this->data = array_merge($this->data, $article);
    }

    /**
     * Maps to:
     *    - site_url + articles/create
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
