<!DOCTYPE html>
<html lang="<?php echo current_lang(); ?>">
    <head>
        <meta charset="utf-8">
        <?= style_tag($styles) ?>
        <title>{pagetitle}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    </head>
    <body>
        <?php $this->load->view('templates/_parts/menu'); ?>
        <div class="container">
            <main>
                <?= action_result() ?>
                <?php $this->load->view($template); ?>
            </main>
            <?php $this->load->view('templates/_parts/footer'); ?>
        </div>
        <?= jscript_tag($jscripts) ?>
    </body>
</html>
