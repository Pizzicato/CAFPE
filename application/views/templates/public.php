<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="<?= css_url() ?>">
        <title>{pagetitle}</title>
    </head>
    <body>
        <?php $this->load->view('templates/_parts/header'); ?>
        <main>
            <?php $this->load->view($content_view); ?>
            <?php $this->load->view('templates/_parts/sidebar'); ?>
        </main>
        <?php $this->load->view('templates/_parts/footer'); ?>
        <script src="<?= jscript_url() ?>" charset="utf-8"></script>
    </body>
</html>
