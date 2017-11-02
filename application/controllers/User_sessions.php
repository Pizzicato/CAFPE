<?php defined('BASEPATH') or exit('No direct script access allowed');

class User_sessions extends Public_controller
{
    public function __construct()
    {
        parent ::__construct();
    }

    /**
     * Maps to:
     *    - site_url + admin/login
     */
    public function create()
    {
        $this->load->library('form_validation');
        $this->load->helper('form');

        $this->form_validation->set_rules('username', lang('username'), 'trim|required');
        $this->form_validation->set_rules('password', lang('password'), 'required');

        if ($this->form_validation->run() === true) {
            $remember = (bool) $this->input->post('remember');
            if ($this->ion_auth->login($this->input->post('username'), $this->input->post('password'), $remember)) {
                redirect_lang('admin/dashboard');
            } else {
                $this->status('error', false, $this->ion_auth->errors());
            }
        }
    }

    /**
     * Maps to:
     *    - site_url + user_sessions/delete/$url
     *
     * @param string $url base64 encoded referer URL
     */
    public function delete($url = '')
    {
        $url = $url ? base64_url_decode($url) : site_url_lang('admin/login');
        if($this->ion_auth->logged_in()){
            $this->ion_auth->logout();
            // Regenerate session: Fix for a ion_auth bug
            session_start();
            $this->session->sess_regenerate(TRUE);
            $this->status('ok', true, $this->ion_auth->messages());
        }

	    redirect($url);
    }
}
