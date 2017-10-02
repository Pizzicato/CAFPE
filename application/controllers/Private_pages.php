<?php defined('BASEPATH') or exit('No direct script access allowed');

class Private_pages extends Auth_controller
{
    /**
     * Maps to:
     *    - site_url + private_pages
     *    - site_url + private_pages/index
     *    - site_url + admin (in routes)
     */
    public function index()
    {
    }
}
