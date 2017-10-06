<!DOCTYPE html>
<html lang="<?php echo current_lang(); ?>">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="<?= css_url() ?>">
        <title>{pagetitle}</title>
    </head>
    <body>
        <?= lang_switcher() ?>
        <?php $this->load->view($template); ?>
    </body>
</html>
