<?php defined('BASEPATH') or exit('No direct script access allowed');

class News extends Auth_controller
{
    public function __construct()
    {
        parent ::__construct();
        $this->load->model('news_model');
    }

    /**
     * Maps to:
     *    - base_url + news
     *    - base_url + news/index
     */
    public function index()
    {
        $news = $this->news_model->as_array()->get_all();
        $this->data['news'] = $news ? $news : [];
    }
}