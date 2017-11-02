<?php defined('BASEPATH') or exit('No direct script access allowed');

class Users extends Auth_controller
{
    public function __construct()
    {
        parent ::__construct();
        //$this->load->model('users_model');
    }

    /**
     * Maps to:
     *    - site_url + users
     *    - site_url + users/index
     */
    public function index()
    {
        // $this->data['users'] = [];
        // $users = $this->users_model->get_all();
        // if($users) {
        //     $this->data['users'] = $users;
        // }
    }

    /**
     * Maps to:
     *    - site_url + users/view/$username
     */
    public function view($username = null)
    {
        // $user = $this->user_model->get($username);
        // if (! $user) {
        //     show_404();
        // }
        //
        // $this->data = array_merge($this->data, $user);
    }

    /**
     * Maps to:
     *    - site_url + users/create
     */
    public function create()
    {
        // $this->load->helper('form');
        // // insert data
        // $username = $this->user_model->from_form()->insert();
        // if ($username) {
        //     $this->status('ok', true);
        //     redirect_lang('admin/users/view/'.$username);
        // }
        // // not valid posted data
        // elseif(!$this->user_model->validatided) {
        //     $this->status('error');
        // }
    }

    /**
     * Maps to:
     *    - site_url + users/edit/$username
     */
    public function edit($username = null)
    {
        // $this->load->helper('form');
        // $this->data['_'] = $this->user_model->get($username);
        // if (! $this->data['_'] || ! $username) {
        //     show_404();
        // }
        // // update data if provided
        // if(!$this->user_model->validated) {
        //     if ($this->user_model->from_form(null, null, array('username' => $username))->update()) {
        //         $this->status('ok', true);
        //         redirect_lang('admin/users/view/'.$username);
        //     }
        //     // not valid posted data
        //     else {
        //         $this->status('error');
        //     }
        // }
    }

    /**
     * Maps to:
     *    - site_url + users/delete/$username
     */
    public function delete($username = null)
    {
        // if ($this->user_model->delete($username)) {
        //     $this->status('ok', true);
        // } else {
        //     $this->status('error', true);
        // }
        // redirect_lang('admin/users');
    }
}
