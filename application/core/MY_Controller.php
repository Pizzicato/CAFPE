<?php defined('BASEPATH') or exit('No direct script access allowed');

/*
 * Base controller with common functionality for all of them
 */
class MY_Controller extends CI_Controller
{
    /**
    * Data that wil be passed to views
    *
    * @var array
    */
    protected $data = array();
    protected $template;
    // View that will be loaded by default: controller/method path inside views folder
    protected $default_view;

    public function __construct($template)
    {
        parent::__construct();
        $this->data['pagetitle'] = 'CAFPE - Centro Andaluz de Física de Partículas Elementales';
        $this->template = $template;
        $this->default_view = $this->router->fetch_class() . '/' . $this->router->fetch_method();

        $this->_language_check();
        $this->_maintenance_mode_check();
    }


    /**
    * Renders passed view
    */
    public function render($view, $return = false)
    {
        if (! $this->_valid_view($view)) {
            show_404();
        }

        $this->data['view'] = (is_null($view)) ? '' : $view;
        return $this->parser->parse($this->template, $this->data, $return);
    }

    /**
    * Override _ouput Ouput class method to allow implicit view rendering
    */
    public function _output($output)
    {
        if ($output) {
            echo $output;
        } else {
            // nothing was rendered from controller, render default view
            echo $this->render($this->default_view, true);
        }
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
            $this->data['view'] = 'maintenance';
            die($this->parser->parse('templates/public', $this->data));
        }
    }

    /**
    * Checks if view file exists in views folder
    */
    private function _valid_view($view)
    {
        $view_file = VIEWPATH . $view.'.php';
        return file_exists($view_file);
    }
}
