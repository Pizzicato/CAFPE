<?php
/**
 * Class with methods to autoload MY_Controller extensions
 */
class AutoLoadHierarchicalControllers
{
    /**
     * Register anonymous function below as autoload() implementation
     */
    public function load_app_controllers()
    {
        spl_autoload_register(function ($class) {
            // only non CodeIgniter controllers
            if (strpos($class, 'CI_') !== 0) {
                if (is_readable(APPPATH . 'core/' . $class . '.php')) {
                    require_once(APPPATH . 'core/' . $class . '.php');
                }
            }
        });
    }
}
