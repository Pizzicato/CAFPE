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
        <td class="text-nowrap"><?= $_['date'] ?></td>
        <td><?= $_['title'] ?></td>
        <td class="text-right text-nowrap">
            <?=
                anchor(
                    site_url_lang('article/'.$_['slug']),
                    '<i data-toggle="tooltip" title="'.lang('view').'" class="fa fa-eye" aria-hidden="true"></i>',
                    array('class' => 'action-icon')
                )
            ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<?php else: ?>
    <p><?= lang('no_records') ?></p>
<?php endif; ?>
