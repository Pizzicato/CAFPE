<?php defined('BASEPATH') or exit('No direct script access allowed');

/*
 * Controller extended by other controllers that load public access views
 */
class Public_Controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        // TODO: Set public template
    }
}
