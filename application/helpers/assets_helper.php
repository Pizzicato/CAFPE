<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Assets Helper
 *
 * @usage     $autoload['config'] = array('asset');
 *            $autoload['helper'] = array('asset');
 *
 */

/**
 * Get css main file URL
 *
 * @access  public
 * @return  string CSS main file location
 */
if ( ! function_exists('css_url'))
{
    function css_url()
    {
        $CI =& get_instance();
        $url = base_url() . $CI->config->item('css_path');
        switch (ENVIRONMENT)
        {
            case 'testing':
            case 'development':
        		$url .= $CI->config->item('main_css_file');
            break;

        	case 'production':
        		$url .= $CI->config->item('main_min_css_file');
        	break;
        }
        return $url;
    }
}

/**
 * Get main js file URL
 *
 * @access  public
 * @return  string
 */
if ( ! function_exists('jscript_url'))
{
    function jscript_url()
    {
        $CI =& get_instance();
        $url = base_url() . $CI->config->item('jscript_path');
        switch (ENVIRONMENT)
        {
            case 'testing':
            case 'development':
        		$url .= $CI->config->item('main_jscript_file');
            break;

        	case 'production':
        		$url .= $CI->config->item('main_min_jscript_file');
        	break;
        }
        return $url;
    }
}
