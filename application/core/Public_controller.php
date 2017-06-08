<?php defined('BASEPATH') or exit('No direct script access allowed');

/*
 * Controller extended by other controllers that load public access views
 */
class Public_controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        // TODO: Set public template
    }

    /**
    * Renders view - This method implements abstract function in MY_Controller
    *
    * @param string $content_view Content view path and name
    */
    protected function render($content_view = null)
    {
        $this->data['content_view'] = (is_null($content_view)) ? '' : $content_view;
        $this->parser->parse('templates/public', $this->data);
    }
}
