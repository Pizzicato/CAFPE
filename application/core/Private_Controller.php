<?php defined('BASEPATH') or exit('No direct script access allowed');

/*
 * Controller extended by other controllers that load private access views
 */
class Private_Controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->_auth_logged_in();
        //TODO: Set private template
    }

    private function _auth_logged_in()
    {
        //Check if user is authenticated
    }
}
