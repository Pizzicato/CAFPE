<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>{pagetitle}</title>
    </head>
    <body>
        <?php
          $this->load->view('templates/_parts/header');
        ?>
        <section>
          {view_content}
        </section>
        <?php
            $this->load->view('templates/_parts/sidebar');

            $this->load->view('templates/_parts/footer');
        ?>
    </body>
</html>
