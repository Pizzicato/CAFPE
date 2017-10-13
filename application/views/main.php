<!DOCTYPE html>
<html lang="<?php echo current_lang(); ?>">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="<?= css_url() ?>">
        <title>{pagetitle}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    </head>
    <body>
        <?= lang_switcher() ?>
        <?php $this->load->view($template); ?>
    </body>
</html>
