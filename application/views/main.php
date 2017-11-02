<!DOCTYPE html>
<html lang="<?php echo current_lang(); ?>">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="<?= css_url() ?>">
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
            <script src="<?= jscript_url() ?>" charset="utf-8"></script>
        </div>
    </body>
</html>
