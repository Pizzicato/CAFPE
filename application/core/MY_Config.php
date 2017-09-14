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

        $uri = ltrim($uri, '/');
        $uri = $uri ? $CI->lang->current.'/'.$uri : $uri;

        return parent::site_url($uri, $protocol);
    }
}
