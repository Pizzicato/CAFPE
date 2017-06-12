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
        $this->data['pagetitle'] = 'CAFPE - Centro Andaluz de Física de Partículas Elementales';

        $this->_language_check();
        $this->_maintenance_mode_check();
    }

    /**
    * Sets language (default or explicitly selected by user)
    */
    private function _language_check()
    {
        # TODO: Set default or language selected by user
    }

    /**
    * Check if site is in maintenance mode. In that case, load
    * maintenance view and stop CI execution
    */
    private function _maintenance_mode_check()
    {
        if ($this->config->item('site_under_maintenance') === true) {
            $this->data['content_view'] = 'maintenance';
            die($this->parser->parse('templates/public', $this->data));
        }
    }
}
