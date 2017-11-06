<?php
    $menu_elements = array(
        'index' => [
                'content' => '<i class="fa fa-home" aria-hidden="true"></i>
                <span class="sr-only">'.lang('index').'</span>',
                'href' => site_url_lang('')
            ],
        'news' => ['content' => lang('news'), 'href' => site_url_lang('news')]
    );
    $current_page = isset($current_page) ? $current_page : '';
?>
<nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">
    <a class="navbar-brand" href="<?=  site_url_lang('') ?>">CAFPE</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mr-auto">
            <?php foreach ($menu_elements as $page => $menu_item): ?>
            <li class="nav-item <?php echo ($page === @$current_page) ? 'active' : '' ?>">
                <a class="nav-link" href="<?= $menu_item['href'] ?>">
                    <?= $menu_item['content'] ?>
                    <?php if($page === @$current_page): ?>
                    <span class="sr-only">(current)</span>
                    <?php endif; ?>
                </a>
            </li>
            <?php endforeach; ?>
        </ul>
        <ul class="navbar-nav">
            <li class="nav-item">
                <?= lang_switcher() ?>
            </li>
            <li class="admin-area-button nav-item">
                <?= admin_area_button() ?>
            </li>
        </ul>
    </div>
</nav>
