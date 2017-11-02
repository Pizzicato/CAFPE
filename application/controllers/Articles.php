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
     *    - site_url + articles/view/$id
     */
    public function view($id = null)
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
        // insert data
        $id = $this->article_model->from_form()->insert();
        if ($id) {
            $this->status('ok', true);
            redirect_lang('admin/articles/view/'.$id);
        }
        // not valid posted data
        elseif($this->input->method() === 'post') {
            $this->status('error');
        }
    }

    /**
     * Maps to:
     *    - site_url + articles/edit/$id
     */
    public function edit($id = null)
    {
        $this->load->helper('form');
        $this->data['_'] = $this->article_model->get($id);
        if (! $this->data['_'] || ! $id) {
            show_404();
        }
        // update data if provided
        if($this->input->method() === 'post') {
            if ($this->article_model->from_form(null, null, array('id' => $id))->update()) {
                $this->status('ok', true);
                redirect_lang('admin/articles/view/'.$id);
            }
            // not valid posted data
            else {
                $this->status('error');
            }
        }
    }

    /**
     * Maps to:
     *    - site_url + articles/delete/$id
     */
    public function delete($id = null)
    {
        if ($this->article_model->delete($id)) {
            $this->status('ok', true);
        } else {
            $this->status('error', true);
        }
        redirect_lang('admin/articles');
    }
}
