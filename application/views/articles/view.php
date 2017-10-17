<?php if($title_en): ?>
<h2>English version: {title_en}</h2>
<div>
    <p>{date}</p>
    <p>{content_en}</p>
</div>
<?php endif; ?>
<?php if($title_es): ?>
<h2>Spanish version: {title_es}</h2>
<div>
    <p>{date}</p>
    <p>{content_es}</p>
</div>
<?php endif; ?>
<?= anchor(site_url_lang('admin/articles'), lang('view_all')) ?>
