<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

$route['default_controller'] = 'pages';
$route['404_override'] = '';

// only lang in URI
$route['(\w{2})'] = $route['default_controller'];

// Admin routes
$route['(\w{2})/admin'] = 'private_pages/index';
$route['(\w{2})/admin/dashboard'] = 'private_pages/index';
$route['(\w{2})/admin/(.*)'] = '$2';

// Public routes (non admin) are all directed to pages controller
// The second segment is the pages controller action, which have to be translated
$route['(\w{2})/(.*)(/.*)'] = function ($lang, $pages_action, $params = '') {
    $LANG =& load_class('Lang', 'core');
    $pages_action = $LANG->translate_to_id($pages_action, $lang);
    // action not translatable
    if(!$pages_action) {
        show_404();
    }
    return 'pages/'.$pages_action.$params;
};

$route['(\w{2})/(.*)'] = $route['(\w{2})/(.*)(/.*)'];
