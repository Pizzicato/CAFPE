<?php defined('BASEPATH') or exit('No direct script access allowed');

/*
 * Controller extended by other controllers that load public access views
 */
class Public_controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct('templates/public');
        // add app jscripts in public area
        $this->data['jscripts'] = ['admin.vendors', 'app'];
        $this->data['styles'] = ['app'];
    }
}
