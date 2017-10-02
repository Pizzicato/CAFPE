<p>PUBLIC</p>
<?php $this->load->view('templates/_parts/header'); ?>
<main>
    <?php $this->load->view($view); ?>
    <?php $this->load->view('templates/_parts/sidebar'); ?>
</main>
<?php $this->load->view('templates/_parts/footer'); ?>
<script src="<?= jscript_url() ?>" charset="utf-8"></script>
