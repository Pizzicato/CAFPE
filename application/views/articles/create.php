<h2>Create new article</h2><br>
<?php
    $attributes = array('id' => 'cafpe_form', 'novalidate' => 'novalidate');
    echo form_open(site_url_lang('admin/articles/create'), $attributes);
    $this->load->view('articles/_form')
?>
