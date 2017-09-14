<?php defined('BASEPATH') or exit('No direct script access allowed');

function current_lang(){
    $CI =& get_instance();

    return $CI->lang->current;
}
