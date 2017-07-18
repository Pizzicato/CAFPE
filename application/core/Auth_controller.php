<?php defined('BASEPATH') or exit('No direct script access allowed');

/*
 * Controller extended by other controllers that load private access views
 */
class Auth_controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct('templates/auth');
        $this->_auth_logged_in();
    }

    /**
    * Checks if user is authenticated
    */
    private function _auth_logged_in()
    {
        //Check if user is authenticated
    }
}
