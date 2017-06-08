<?php defined('BASEPATH') or exit('No direct script access allowed');

/*
 * Controller extended by other controllers that load private access views
 */
class Auth_controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->_auth_logged_in();
        //TODO: Set private template
    }

    /**
    * Renders view - This method implements abstract function in MY_Controller
    *
    * @param string $content_view Content view path and name
    */
    protected function render($content_view = null)
    {
        $this->data['content_view'] = (is_null($content_view)) ? '' : $content_view;
        $this->parser->parse('templates/auth', $this->data);
    }

    /**
    * Checks if user is authenticated
    */
    private function _auth_logged_in()
    {
        //Check if user is authenticated
    }
}
