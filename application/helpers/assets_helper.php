<?php defined('BASEPATH') or exit('No direct script access allowed');
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
 if (! function_exists('style_tag')) {
    function style_tag($styles)
    {
        $CI =& get_instance();
        $base_css_path = base_url() . $CI->config->item('css_path');
        $output = '';

        foreach ($styles as $style) {
            $output .= "<link rel=\"stylesheet\" href=\"".$base_css_path;
            $output .= "$style.css\">\n";
        }
        return $output;
    }
}

/**
 * Get main js file URL
 *
 * @access  public
 * @return  string
 */
if (! function_exists('jscript_tag')) {
    function jscript_tag($jscripts)
    {
        $CI =& get_instance();
        $base_jscript_path = base_url() . $CI->config->item('jscript_path');
        $output = '';
        foreach ($jscripts as $jscript) {
            $output .= "<script src=\"$base_jscript_path";
            $output .= "$jscript.js\" charset=\"utf-8\" defer></script>\n";
        }

        return $output;
    }
}
