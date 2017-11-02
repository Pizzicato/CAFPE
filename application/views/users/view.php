<div>
    <h3><?= lang('User') ?>: {username}</h3>
    <div>
        <p>{lastname}, {name}</p>
    </div>
</div>
<div class="clearfix">
    <?= anchor(site_url_lang('admin/users'), lang('view_all'), ['class' => 'float-left']) ?>
    <?= anchor(site_url_lang('admin/users/edit/'.$id), lang('edit'), ['class' => 'float-right']) ?>
</div>
