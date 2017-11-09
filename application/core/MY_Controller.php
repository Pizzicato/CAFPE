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
    // View that will be loaded by default: controller/method path inside views folder
    protected $default_view;
    // requested action status
    public $status = [];

    public function __construct($template)
    {
        parent::__construct();

        // load ionauth library
        $this->load->add_package_path(APPPATH.'libraries/ionauth/');
        $this->load->library('ion_auth');

        // set common data for all controllers
        $this->data['pagetitle'] = 'CAFPE - Centro Andaluz de Física de Partículas Elementales';
        $this->data['template'] = $template;
        $this->default_view = $this->router->fetch_class() . '/' . $this->router->fetch_method();
        $this->data['jscripts'] = ['main.vendors', 'main'];
        $this->data['styles'] = ['main'];

        // check if app is in maintenance mode
        $this->_maintenance_mode_check();
    }


    /**
    * Renders passed view
    * @param string $view view name
    * @param bool $return render image directly or return as string
    */
    public function render($view, $return = false)
    {
        if (! $this->_valid_view($view)) {
            show_404();
        }

        $this->data['view'] = (is_null($view)) ? '' : $view;
        return $this->parser->parse('main.php', $this->data, $return);
    }

    /**
    * Override _ouput Ouput class method to allow implicit view rendering
    * @param string $output
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
    * Saves controller action status, if it has not been set before
     * @param string $action Name of performed action (create, edit, delete...)
     * @param string $class ok or error
     * @return	bool
     */
    public function status($class, $redirect = false , $custom_message = '')
    {
        $action = $this->router->fetch_method();
        $message = $custom_message ? $custom_message : $this->lang->line($action.'_'.$class, FALSE);
        if(!empty($this->status) && ($class !== 'ok' && $class !== 'error') || !$message) {
            return false;
        }
        $status = $this->status = array(
            'message' => $message,
            'class' => $class
        );

        if($redirect) {
            $_SESSION['status'] = $status;
            $this->session->mark_as_flash('status');
        } else {
            $this->status = $status;
        }

        return true;
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
    * @param string $view view name
    * @return	bool
    */
    private function _valid_view($view)
    {
        $view_file = VIEWPATH . $view.'.php';
        return file_exists($view_file);
    }
}
