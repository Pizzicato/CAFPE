<?php defined('BASEPATH') or exit('No direct script access allowed');

function current_lang(){
    $CI =& get_instance();

    return $CI->lang->current;
}

function lang_switcher()
{
    $CI =& get_instance();

    // get languages
    $lang = current_lang();
    $other_lang = $lang === 'es' ? 'en' : 'es';
    // get URI and remove first segment (lang)
    $uri = $CI->uri->segment_array();
    array_shift($uri);
    // public page, Page controller action sould be translated to other language
    if($uri && $uri[0] !== 'admin') {
        $uri[0] = $CI->lang->translate($uri[0], $lang, $other_lang);
    }
    $uri = implode('/',$uri);
    $url = site_url_lang($uri, $other_lang);

    $output = '';
    switch ($lang) {
        case 'es':
            $output .= anchor($url, 'English', 'class="nav-link"');
            break;

        case 'en':
            $output .= anchor($url, 'Español', 'class="nav-link"');
            break;
    }

    return $output;

}

function site_url_lang($uri, $lang = '', $protocol = null)
{
    return get_instance()->lang->site_url_lang($uri, $lang, $protocol);
}

function redirect_lang($uri = '', $lang = '', $method = 'auto', $code = NULL)
{
    return get_instance()->lang->redirect_lang($uri, $lang, $method, $code);
}
