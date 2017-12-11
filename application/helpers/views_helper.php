<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Views Helper
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
                    <button type="button" class="close" data-dismiss="alert" aria-label="'.lang('close').'">
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
        $icons = array('view' => 'eye', 'edit' => 'pencil', 'delete' => 'trash-o');
        foreach ($actions as $action) {
            $attributes = ['class' => 'action-icon'];
            $modal = '';
            if($action == 'delete') {
                $attributes = array_merge(
                    $attributes,
                    ['data-toggle' => 'modal', 'data-target' => '#deleteModal']
                );
                $modal = '
                    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel">'.lang('delete').'</h5>
                                </div>
                                <div class="modal-body text-left">'.lang('delete_confirm').'</div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">'.lang('close').'</button>
                                    <a class="btn btn-primary" href="'.site_url_lang($uri.'/'.$action.'/'.$id).'" role="button">'.lang('delete').'</a>
                                </div>
                            </div>
                        </div>
                    </div>';
            }

            $output .= anchor(
                site_url_lang($uri.'/'.$action.'/'.$id),
                '<i data-toggle="tooltip" title="'.lang($action).'" class="fa fa-'.$icons[$action].'" aria-hidden="true"></i>',
                $attributes
            ).$modal;
        }

        return $output;
    }
}

/**
 * Prints status from last action using flash data
 */
if (! function_exists('admin_area_buttons')) {
    function admin_area_buttons()
    {
        $admin_area_title = lang('admin_area');
        $admin_area_href = site_url_lang('admin/dashboard');
        $admin_area_button = "
            <a data-toggle=\"tooltip\" title=\"$admin_area_title\" class=\"btn btn-success\" href=\"$admin_area_href\">
                <i class=\"fa fa-lock\" aria-hidden=\"true\"></i>
                <span class=\"sr-only\">$admin_area_title</span>
            </a>";

        if (logged_in()){
            $title_logout = lang('logout');
            $href_logout = site_url_lang('admin/logout/'.base64_current_url_encode());
            return "<div class=\"btn-group\" role=\"group\" aria-label=\"Admin Area\">".
                            $admin_area_button."
                            <a data-toggle=\"tooltip\" title=\"$title_logout\" class=\"btn btn-success\" href=\"$href_logout\">
                                <i class=\"fa fa-sign-out\" aria-hidden=\"true\"></i>
                                <span class=\"sr-only\">$title_logout</span>
                            </a>
                    </div>";
        }
        return $admin_area_button;
    }
}
