<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Base controller with common functionality for all of them
 */
class MY_Controller extends CI_Controller
{
	function MY_Controller()
	{
		parent::__construct();
		$this->_language_check();
	}

    private function _language_check()
    {
        # TODO: Set default or language selected by user
    }
}
