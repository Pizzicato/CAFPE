<h2>Edit article</h2>
<?php
    $attributes = array('id' => 'cafpe_form', 'novalidate' => 'novalidate');
    echo form_open(site_url_lang('admin/articles/edit/'.$_['id']), $attributes);
    $this->load->view('articles/_form')
?>
