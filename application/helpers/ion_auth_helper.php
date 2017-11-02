<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * IonAuth Helper
 *
 */

/**
 * Check if user is logged in
 */
if (! function_exists('logged_in')) {
    function logged_in()
    {
        return get_instance()->ion_auth->logged_in();
    }
}
