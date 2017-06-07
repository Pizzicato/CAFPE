<?php defined('BASEPATH') or exit('No direct script access allowed');

/*
 * Base controller with common functionality for all of them
 */
abstract class MY_Controller extends CI_Controller
{
    // Data that wil be passed to views
    protected $data = array();

    //make children classes define render method
    abstract protected function render($view);

    public function __construct()
    {
        parent::__construct();
        $this->_language_check();
        $this->data['pagetitle'] = 'CAFPE - Centro Andaluz de Física de Partículas Elementales';
    }

    private function _language_check()
    {
        # TODO: Set default or language selected by user
    }
}
