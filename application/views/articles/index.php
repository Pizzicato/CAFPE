<h3><?= lang('news') ?></h3><br>
<?php if ($articles): ?>
<table class="table table-striped table-hover">
    <thead>
    <tr>
        <th><?= lang('date') ?></th>
        <th><?= lang('title') ?></th>
        <th></th>
    </tr>
    </thead>
    <?php foreach ($articles as $_) : ?>
    <tr>
        <td><?= $_['date'] ?></td>
        <td><?= $_['title_es'] ? $_['title_es'] : $_['title_en'] ?></td>
        <td>
            <?= actions_widget("admin/articles", $_['id']) ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<?php else: ?>
    <p><?= lang('no_records') ?></p>
<?php endif; ?>
<div class="text-right">
    <a href="<?= site_url_lang("admin/articles/create") ?>">
        <i data-toggle="tooltip" title="<?= lang('create_new') ?>" class="fa fa-plus-circle fa-2x" aria-hidden="true"></i>
    </a>
</div>
