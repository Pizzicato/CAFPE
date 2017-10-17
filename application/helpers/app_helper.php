<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * App Helper
 *
 */

/**
 * Prints status from last action using flash data
 */
if (! function_exists('action_result')) {
    function action_result()
    {
        $CI =& get_instance();
        $status = @$_SESSION['status'] ? $_SESSION['status'] : $CI->status;

        if(isset($status['class'], $status['message'])){
            switch ($status['class']) {
                case 'ok':
                    $class = 'alert alert-success alert-dismissible fade show';
                    break;

                case 'error':
                    $class = 'alert alert-warning alert-dismissible fade show';
                    break;

                default:
                     return false;
            }

            return '<div class="'.$class.'" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="'.lang('close').'>
                        <span aria-hidden="true">&times;</span>
                    </button>
                    '.$status['message'].'
                </div>';
        }
    }
}

/**
 * Prints status from last action using flash data
 */
if (! function_exists('actions_widget')) {
    function actions_widget($uri, $id, $actions = ['view', 'edit', 'delete'])
    {
        $output = '';
        $delete_js = '';
        $icons = array('view' => 'eye', 'edit' => 'pencil', 'delete' => 'trash-o');
        foreach ($actions as $action) {
            $onclick = ($action === 'delete') ?
                            'onclick="return confirm(\''.lang('delete_confirm').'\')"' :
                            '';
            $output .=
                '<a href="'.site_url_lang($uri.'/'.$action.'/'.$id).'" '.$onclick.'>
                    <i data-toggle="tooltip" title="'.lang($action).'" class="fa fa-'.$icons[$action].'" aria-hidden="true"></i>
                </a>';
        }

        return $output;
    }
}
