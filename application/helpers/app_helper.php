<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * App Helper
 *
 */

if (! function_exists('base64_url_encode')) {
    function base64_url_encode($input) {
        return strtr(base64_encode($input), '+/=', '._-');
    }
}

if (! function_exists('base64_url_decode')) {
    function base64_url_decode($input) {
        return base64_decode(strtr($input, '._-', '+/='));
    }
}

if (! function_exists('base64_current_url_encode')) {
    function base64_current_url_encode() {
        return base64_url_encode(current_url());
    }
}
