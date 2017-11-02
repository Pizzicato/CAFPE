<h3><?= lang('users') ?></h3><br>
<?php if ($users): ?>
<table class="table table-striped table-hover">
    <thead>
    <tr>
        <th><?= lang('username') ?></th>
        <th><?= lang('name') ?></th>
        <th><?= lang('email') ?></th>
        <th></th>
    </tr>
    </thead>
    <?php foreach ($users as $_) : ?>
    <tr>
        <td><?= $_['username'] ?></td>
        <td class="text-nowrap"><?= $_['lastname'].", ".$_['name'] ?></td>
        <td class="text-right text-nowrap">
            <?= actions_widget("admin/users", $_['username']) ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<?php else: ?>
    <p><?= lang('no_records') ?></p>
<?php endif; ?>
<div class="text-right">
    <a href="<?= site_url_lang("admin/users/create") ?>">
        <i data-toggle="tooltip" title="<?= lang('create_new') ?>" class="fa fa-plus-circle fa-2x" aria-hidden="true"></i>
    </a>
</div>
