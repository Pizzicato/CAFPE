<?= form_open(
        site_url_lang('admin/login'),
        array('id' => 'login-form', 'novalidate' => 'novalidate', 'class' => 'form-signin')
    )
?>
<h2><?= lang('login') ?></h2><br>
<?= validation_errors('<p class="text-danger">', '</p>') ?>

<div class="form-group">
    <?= form_label(lang('username'), 'username') ?>
    <?= form_input(
            array(
                'name' => 'username',
                'value' => set_value('username', @$_['username']),
                'id'=> 'username',
                'required' => 'required',
                'class' => (form_error('username') ? 'is-invalid ' : '').'form-control'
            )
    ) ?>
</div>

<div class="form-group">
    <?= form_label(lang('password'), 'password') ?>
    <?= form_password(
            array(
                'name' => 'password',
                'id'=> 'password',
                'required' => 'required',
                'class' => (form_error('password') ? 'is-invalid ' : '').'form-control'
            )
    ) ?>
</div>
<div class="form-check">
    <label  class="form-check-label">
        <?= form_checkbox(
                array(
                    'name' => 'remember',
                    'value' => '1',
                    'class' => 'form-check-input'
                )
            )
        ?>
        <?= lang('remember_me') ?>
    </label>
</div>
<?= form_button(
    array(
            'type' => 'submit',
            'content' => lang('send'),
            'class' => 'btn btn-lg btn-outline-primary btn-block'
        )
    ) ?>
<?= form_close()?>
