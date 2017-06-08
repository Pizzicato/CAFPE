<?php defined('BASEPATH') or exit('No direct script access allowed');

/*
 * Base controller with common functionality for all of them
 */
abstract class MY_Controller extends CI_Controller
{
    /**
    * Data that wil be passed to views
    *
    * @var array
    */
    protected $data = array();

    /**
    * Make children classes define render method
    */
    abstract protected function render($content_view);

    public function __construct()
    {
        parent::__construct();
        $this->_language_check();
        $this->data['pagetitle'] = 'CAFPE - Centro Andaluz de Física de Partículas Elementales';
    }

    /**
    * Sets language (default or explicitly selected by user)
    */
    private function _language_check()
    {
        # TODO: Set default or language selected by user
    }
}
