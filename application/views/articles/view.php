<?php if($title_en): ?>
<div>
    <h3><?= lang('english') ?>: {title_en}</h3>
    <div>
        <p class="text-right">{date}</p>
        {content_en}
    </div>
</div>
<br>
<?php endif; ?>
<?php if($title_es): ?>
<div>
    <h3><?= lang('spanish') ?>: {title_es}</h3>
    <div>
        <p class="text-right">{date}</p>
        {content_es}
    </div>
</div>
<br>
<?php endif; ?>
<div class="clearfix">
    <?= anchor(site_url_lang('admin/articles'), lang('view_all'), ['class' => 'float-left']) ?>
    <?= anchor(site_url_lang('admin/articles/edit/'.$id), lang('edit'), ['class' => 'float-right']) ?>
</div>
