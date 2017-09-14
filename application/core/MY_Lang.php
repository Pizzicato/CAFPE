<?php defined('BASEPATH') or exit('No direct script access allowed');

class MY_Lang extends CI_Lang
{
    public $current = '';

    public function __construct()
    {
        parent::__construct();

        $URI =& load_class('URI', 'core');
        $CONFIG =& load_class('Config', 'core');

        // get URI segment that should define the language
        $lang_uri = $URI->segment(1);

        // default language, only for home page
        if ($lang_uri === null) {
            $lang_uri = $CONFIG->item('language_abbr');
        }

        // save language if it's valid (has been defined in config file)
        if (in_array($lang_uri, $CONFIG->item('languages_abbr'))) {
            $this->current = $lang_uri;
            $CONFIG->set_item('language', $CONFIG->item('lang_uri_abbr')[$lang_uri]);
        }
        else if(! is_cli()) {
            show_404();
        }
    }
}
