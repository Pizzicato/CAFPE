<?= validation_errors('<p class="text-danger">', '</p>') ?>
<?= form_open(
        site_url_lang('admin/articles/'.$action.'/'.@$_['id']),
        array('id' => 'article-form', 'novalidate' => 'novalidate')
    )
?>
<div class="form-group">
    <?= form_label(lang('date'), 'date') ?>
    <?= form_input(
            array(
                'name' => 'date',
                'value' => set_value('date', @$_['date']),
                'id'=> 'date',
                'class' => (form_error('date') ? 'is-invalid ' : '').'form-control datepicker',
                'required' => 'required',
                'placeholder' => 'DD-MM-YYYY'
            )
        ) ?>
</div>
<fieldset>
    <legend><?= lang('lang_version_es')?></legend>
    <div class="form-group">
        <?= form_label(lang('title_es'), 'title_es') ?>
        <?= form_input(
            'title_es',
            set_value('title_es', @$_['title_es']),
            array(
                    'class' => (form_error('title_es') ? 'is-invalid' : '').' form-control',
                    'id' => 'title_es',
                    'data-validate-depends-on' => 'content_es',
                    'data-validate-all-empty' => 'content_es, title_en, content_en'
                )
            )
        ?>
    </div>
    <div class="form-group">
        <?= form_label(lang('content_es'), 'content_es') ?>
        <?= form_textarea(
                array(
                    'name' => 'content_es',
                    'value' => set_value('content_es', @$_['content_es'], false),
                    'id'=> 'content_es',
                    'rows' => 8,
                    'class' => (form_error('content_es') ? 'form-control is-invalid' : 'form-control'),
                    'data-validate-depends-on' => 'title_es'
                )
            ) ?>
    </div>
</fieldset>
<fieldset>
    <legend><?= lang('lang_version_en')?></legend>
    <div class="form-group">
        <?= form_label(lang('title_en'), 'title_en') ?>
        <?= form_input(
                'title_en',
                set_value('title_en', @$_['title_en']),
                array(
                    'class' => (form_error('title_en') ? 'is-invalid' : 'ok').' form-control',
                    'id' => 'title_en',
                    'data-validate-depends-on' => 'content_en'
                )
            )
        ?>
    </div>
    <div class="form-group">
        <?= form_label(lang('content_en'), 'content_en'); ?>
        <?= form_textarea(
                array(
                    'name' => 'content_en',
                    'value' => set_value('content_en', @$_['content_en'], false),
                    'id'=> 'content_en',
                    'rows' => 8,
                    'class' => (form_error('content_en') ? 'form-control is-invalid' : 'form-control'),
                    'data-validate-depends-on' => 'title_en'
                )
            )
        ?>
    </div>
</fieldset>
<div class="clearfix">
    <div class="float-right">
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
