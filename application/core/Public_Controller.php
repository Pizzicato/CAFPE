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

    protected function render($view = null)
    {
        $this->data['view_content'] = (is_null($view)) ? '' : $this->load->view($view, $this->data, true);
        $this->parser->parse('templates/public', $this->data);
    }
}
