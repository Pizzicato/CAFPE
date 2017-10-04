<?php defined('BASEPATH') or exit('No direct script access allowed');

/*
 * Extension of CI_Config to add language URI segment in site_url method
 */
class MY_Config extends CI_Config
{
    /**
	 * Site URL
	 *
	 * Returns base_url . index_page . $lang [. uri_string]
	 *
	 * @uses	CI_Config::_uri_string()
	 *
	 * @param	string|string[]	$uri	URI string or an array of segments
	 * @param	string	$protocol
	 * @return	string
	 */
	public function site_url($uri = '', $protocol = NULL)
	{
        $CI =& get_instance();

        $lang = $CI->lang->current;
        $uri = ltrim($uri, '/');
        if($uri){
            // get controller and params from URI
            preg_match( "/^([^\/]*)(\/.*)?$/", $uri, $m);
            $controller = $m[1];
            $params = isset($m[2]) ? $m[2] : '';
            // translate given controller name to current language
            $controller = $CI->lang->t_controller($controller);
            // add language to beginning of URI
            $uri = $lang.'/'.$controller.$params;
        }

        return parent::site_url($uri, $protocol);
    }
}
