<?= validation_errors('<p class="text-danger">', '</p>') ?>
<?= form_open(
        site_url_lang('admin/articles/'.$action.'/'.@$_['id']),
        array('id' => 'article-form', 'novalidate' => 'novalidate')
    )
?>
<div class="form-group row">
    <?= form_label(lang('date'), 'date', array('class' => "col-sm-2 col-form-label")) ?>
    <div class="col-sm-10">
        <?= form_input(
                array(
                    'name' => 'date',
                    'value' => set_value('date', @$_['date']),
                    'id'=> 'date',
                    'class' => (form_error('date') ? 'is-invalid ' : '').'form-control datepicker',
                    'placeholder' => 'DD-MM-YYYY'
                )
            ) ?>
    </div>
</div>
<fieldset>
    <legend><?= lang('lang_version_es')?></legend>
    <div class="form-group row">
        <?= form_label(lang('title'), 'title_es', array('class' => "col-sm-2 col-form-label")) ?>
        <div class="col-sm-10">
            <?= form_input(
                'title_es',
                set_value('title_es', @$_['title_es']),
                array(
                    'class' => (form_error('title_es') ? 'is-invalid' : '').' form-control',
                    'id' => 'title_es')
                )
            ?>
        </div>
    </div>
    <div class="form-group row">
        <?= form_label(lang('content'), 'content_es', array('class' => "col-sm-2 col-form-label")) ?>
        <div class="col-sm-10">
            <?= form_textarea(
                    array(
                        'name' => 'content_es',
                        'value' => set_value('content_es', @$_['content_es']),
                        'id'=> 'content_es',
                        'rows' => 4,
                        'class' => (form_error('content_es') ? 'form-control is-invalid' : 'form-control')
                    )
                ) ?>
        </div>
    </div>
</fieldset>
<fieldset>
    <legend><?= lang('lang_version_en')?></legend>
    <div class="form-group row">
        <?= form_label(lang('title'), 'title_en', array('class' => "col-sm-2 col-form-label")) ?>
        <div class="col-sm-10">
            <?= form_input(
                    'title_en',
                    set_value('title_en', @$_['title_en']),
                    array(
                        'class' => (form_error('title_en') ? 'is-invalid' : 'ok').' form-control',
                        'id' => 'title_en')
                    )
            ?>
        </div>
    </div>
    <div class="form-group row">
        <?= form_label(lang('content'), 'content_en', array('class' => "col-sm-2 col-form-label")); ?>
        <div class="col-sm-10">
            <?= form_textarea(
                    array(
                        'name' => 'content_en',
                        'value' => set_value('content_en', @$_['content_en']),
                        'id'=> 'content_en',
                        'rows' => 4,
                        'class' => (form_error('content_en') ? 'form-control is-invalid' : 'form-control')
                    )
                )
            ?>
        </div>
    </div>
</fieldset>
<div class="clearfix">
    <div class="form-group row float-right">
        <?= form_button(
                array(
                    'type' => 'submit',
                    'content' => lang('save'),
                    'class' => 'btn btn-outline-primary'
                )
            )
        ?>
    </div>
</div>
<?= form_close()?>
<div class="text-left">
    <?= anchor(site_url_lang('admin/articles'), lang('view_all')) ?>
</div>
