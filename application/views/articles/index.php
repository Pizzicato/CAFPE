<h3>News</h3>
<?php if($articles): ?>
<table>
    <?php foreach ($articles as $_) : ?>
    <tr>
        <td><?= $_['date'] ?></td>
        <td><?= $_['title_es'] ? $_['title_es'] : $_['title_en'] ?></td>
        <td><a href="<?= site_url_lang("admin/articles/view/{$_['id']}") ?>">view</a></td>
    </tr>
    <?php endforeach; ?>
</table>
<?php else: ?>
    <p>Sorry, there aren't any articles yet</p>
<?php endif; ?>
