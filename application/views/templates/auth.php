<!DOCTYPE html>
<html lang="<?php echo current_lang(); ?>">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="<?= css_url() ?>">
        <title>{pagetitle}</title>
    </head>
    <body>
        <p>PRIVATE</p>
        <?php $this->load->view('templates/_parts/header'); ?>
        <main>
            <?php $this->load->view($view); ?>
            <?php $this->load->view('templates/_parts/sidebar'); ?>
        </main>
        <?php $this->load->view('templates/_parts/footer'); ?>
        <script src="<?= jscript_url() ?>" charset="utf-8"></script>
    </body>
</html>
