<?= validation_errors('<p class="text-danger">', '</p>') ?>
<?php
    $attributes = array('id' => 'cafpe_form', 'novalidate' => 'novalidate');
    echo form_open(site_url_lang('admin/articles/'.$action.'/'.@$_['id']), $attributes);
 ?>
<div class="form-group row">
    <?php
        $data = array(
            'name' => 'date',
            'value' => date('Y-m-d'),
            'id'=> 'date',
            'readonly' => 'readonly',
            'class' => 'form-control'
        );
        echo form_label(lang('date'), 'date', array('class' => "col-sm-2 col-form-label"));
    ?>
    <div class="col-sm-10">
        <?= form_input($data) ?>
    </div>
</div>
<div class="form-group row">
    <?= form_label('Title in Spanish', 'title_es', array('class' => "col-sm-2 col-form-label")) ?>
    <div class="col-sm-10">
        <?= form_input('title_es', set_value('title_es', @$_['title_es']), array('class' => (form_error('title_es') ? 'is-invalid' : '').' form-control')) ?>
    </div>
</div>
<div class="form-group row">
    <?php
        $data = array(
            'name' => 'content_es',
            'value' => set_value('content_es', @$_['content_es']),
            'id'=> 'content_es',
            'rows' => 4,
            'class' => (form_error('content_es') ? 'form-control is-invalid' : 'form-control')
        );
        echo form_label('Content in Spanish', 'content_es', array('class' => "col-sm-2 col-form-label"));
    ?>
    <div class="col-sm-10">
        <?= form_textarea($data) ?>
    </div>
</div>
<div class="form-group row">
    <?= form_label('Title in English', 'title_en', array('class' => "col-sm-2 col-form-label")) ?>
    <div class="col-sm-10">
        <?= form_input('title_en', set_value('title_en', @$_['title_en']), array('class' => (form_error('title_en') ? 'is-invalid' : 'ok').' form-control')) ?>
    </div>
</div>
<div class="form-group row">
    <?php
        $data = array(
            'name' => 'content_en',
            'value' => set_value('content_en', @$_['content_en']),
            'id'=> 'content_en',
            'rows' => 4,
            'class' => (form_error('content_en') ? 'form-control is-invalid' : 'form-control')
        );
        echo form_label('Content in English', 'content_en', array('class' => "col-sm-2 col-form-label"));
    ?>
    <div class="col-sm-10">
        <?= form_textarea($data) ?>
    </div>
</div>
<div class="clearfix">
    <div class="form-group row float-right">
        <?php
            $data = array(
                'type' => 'submit',
                'content' => 'Save',
                'class' => 'btn btn-outline-primary'
            );
            echo form_button($data);
        ?>
    </div>
</div>
<?php echo form_close()?>
<div class="text-left">
    <?= anchor(site_url_lang('admin/articles'), lang('view_all')) ?>
</div>
